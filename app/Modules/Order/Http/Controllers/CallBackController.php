<?php

namespace App\Modules\Order\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Employ\Models\EmployModel;
use App\Modules\Manage\Model\ConfigModel;
use App\Modules\Order\Model\OrderModel;
use App\Modules\Order\Model\ShopOrderModel;
use App\Modules\Shop\Models\GoodsModel;
use App\Modules\User\Model\UserDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Omnipay;

class CallBackController extends Controller
{
    /**
     * 支付宝同步回调处理
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function alipayReturn(Request $request)
    {
        $gateway = Omnipay::gateway('alipay');
        $config = ConfigModel::getPayConfig('alipay');

        $gateway->setPartner($config['partner']);
        $gateway->setKey($config['key']);
        $gateway->setSellerEmail($config['sellerEmail']);
        $gateway->setReturnUrl(env('ALIPAY_RETURN_URL', url('/order/pay/alipay/return')));
        $gateway->setNotifyUrl(env('ALIPAY_NOTIFY_URL', url('/order/pay/alipay/notify')));

        $options = [
            'request_params' => $_REQUEST,
        ];

        $response = $gateway->completePurchase($options)->send();

        if ($response->isSuccessful() && $response->isTradeStatusOk()) {
            $data = array(
                'pay_account' => $request->get('buyer_email'),//支付账号
                'code' => $request->get('out_trade_no'),//订单编号
                'pay_code' => $request->get('trade_no'),//支付宝订单号
                'money' => $request->get('total_fee'),//支付金额
            );

            $type = ShopOrderModel::handleOrderCode($data['code']);

            return $this->alipayReturnHandle($type, $data);

        } else {
            //支付失败通知.
            exit('支付失败');
        }
    }

    /**
     * 支付宝异步回调
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function alipayNotify(Request $request)
    {
        $gateway = Omnipay::gateway('alipay');

        $config = ConfigModel::getPayConfig('alipay');

        $gateway->setPartner($config['partner']);
        $gateway->setKey($config['key']);
        $gateway->setSellerEmail($config['sellerEmail']);
        $gateway->setReturnUrl(env('ALIPAY_RETURN_URL', url('/order/pay/alipay/return')));
        $gateway->setNotifyUrl(env('ALIPAY_NOTIFY_URL', url('/order/pay/alipay/notify')));

        $options = [
            'request_params' => $_REQUEST,
        ];

        $response = $gateway->completePurchase($options)->send();

        if ($response->isSuccessful() && $response->isTradeStatusOk()) {
            $data = array(
                'pay_account' => $request->get('buyer_email'),//支付账号
                'code' => $request->get('out_trade_no'),//订单编号
                'pay_code' => $request->get('trade_no'),//支付宝订单号
                'money' => $request->get('total_fee'),//支付金额
            );

            $type = ShopOrderModel::handleOrderCode($data['code']);

            return $this->alipayNotifyHandle($type, $data);

        } else {
            //支付失败通知.
            exit('支付失败');
        }
    }

    /**
     * 根据订单类型处理同步回调逻辑
     *
     * @param $type
     * @param $data
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function alipayReturnHandle($type, $data)
    {
        switch ($type){
            case 'cash':
                $res = OrderModel::where('code', $data['code'])->first();
                if (!empty($res) && $res->status == 0) {
                    $orderModel = new OrderModel();
                    $status = $orderModel->recharge('alipay', $data);
                    if ($status) {
                        echo '支付成功';
                        return redirect('finance/cash');
                    }
                }
                break;
            case 'pub task':
                break;
            case 'pub goods':
                $data['pay_type'] = 2;
                $shopOrder = ShopOrderModel::where(['code' => $data['code'], 'status' => 0, 'object_type' => 3])->first();
                if (!empty($shopOrder)){
                    $status = ShopOrderModel::thirdBuyShopService($shopOrder->code, $data);
                    if ($status){
                        //支付成功后操作
                        echo('支付成功');
                        return redirect('user/waitGoodsHandle/'.$shopOrder->object_id);
                    }
                }
                break;
            case 'employ':
                //给用户充值
                $result = UserDetailModel::recharge($this->user['id'], 2, $data);
                if (!$result) {
                    echo '支付失败！';
                }
                $order = ShopOrderModel::where('code',$data['code'])->first();
                $employ = EmployModel::where('id',$order['object_id'])->first();
                $result2 = EmployModel::employBounty($data['money'], $order['object_id'], Auth::user()['id'], $data['code']);
                if($result2)
                {
                    echo('支付成功');
                    return Redirect::route('success',['id' => $order['object_id'],'uid'=>$employ['employee_uid']]);
                }
                break;
            case 'pub service':
                //给用户充值
                $result = UserDetailModel::recharge($this->user['id'], 2, $data);
                if (!$result) {
                    echo '支付失败！';
                }
                $order = ShopOrderModel::where('code',$data['code'])->first();
                $result = GoodsModel::servicePay($data['money'],Auth::user()['id'],$order['object_id'],$order['id']);
                $service = GoodsModel::where('id',$order['object_id'])->first();
                //跳转到置顶页面
                if(!$result)
                    echo '支付失败！';

                return redirect()->to('user/serviceList')->with(['message'=>'您的服务成功被置顶到商城,'.date('Y-m-d',strtotime($service['recommend_end'])).'到期']);
                break;
            case 'buy goods':
                $data['pay_type'] = 2;
                $res = ShopOrderModel::where(['code'=>$data['code'],'status'=>0,'object_type' => 2])->first();
                if (!empty($res)){
                    $status = ShopOrderModel::thirdBuyGoods($res->code, $data);
                    if ($status) {
                        //查询商品数据
                        $goodsInfo = GoodsModel::where('id',$res->object_id)->first();
                        //修改商品销量
                        $salesNum = intval($goodsInfo->sales_num + 1);
                        GoodsModel::where('id',$goodsInfo->id)->update(['sales_num' => $salesNum]);
                        echo '支付成功';
                        return redirect('shop/confirm/'.$res->id);
                    }
                }
                break;
            case 'buy service':

                break;
            case 'buy shop service':
                break;
        }
    }

    /**
     * 微信支付异步回调
     *
     * @return mixed
     */
    public function wechatNotify()
    {
        //获取微信回调参数
        $arrNotify = \CommonClass::xmlToArray($GLOBALS['HTTP_RAW_POST_DATA']);


        if ($arrNotify['result_code'] == 'SUCCESS' && $arrNotify['return_code'] == 'SUCCESS') {
            $data = array(
                'pay_account' => $arrNotify['openid'],
                'code' => $arrNotify['out_trade_no'],
                'pay_code' => $arrNotify['transaction_id'],
                'money' => $arrNotify['total_fee'] / 100,
            );

            $type = ShopOrderModel::handleOrderCode($data['code']);

            return $this->wechatNotifyHandle($type, $data);
        }
    }

    /**
     * 根据订单类型处理支付宝异步回调逻辑
     *
     * @param $type
     * @param $data
     */
    public function alipayNotifyHandle($type, $data)
    {
        switch ($type){
            case 'cash':
                $res = OrderModel::where('code', $data['code'])->first();
                if (!empty($res) && $res->status == 0) {
                    $orderModel = new OrderModel();
                    $staus = $orderModel->recharge('alipay', $data);
                    if ($staus) {
                        exit('支付成功');
                    }
                }
                break;
            case 'pub task':
                break;
            case 'pub goods':
                $data['pay_type'] = 2;
                $shopOrder = ShopOrderModel::where(['code' => $data['code'], 'status' => 0, 'object_type' => 3])->first();
                if (!empty($shopOrder)){
                    $status = ShopOrderModel::thirdBuyShopService($shopOrder->code, $data);
                    if ($status){
                        //支付成功后操作
                        exit('支付成功');
                    }
                }
                break;
            case 'pub service':
                break;
            case 'buy goods':
                $data['pay_type'] = 2;
                $res = ShopOrderModel::where(['code'=>$data['code'],'status'=>0,'object_type' => 2])->first();
                if (!empty($res)){
                    $status = ShopOrderModel::thirdBuyGoods($res->code, $data);
                    if ($status) {
                        //查询商品数据
                        $goodsInfo = GoodsModel::where('id',$res->object_id)->first();
                        //修改商品销量
                        $salesNum = intval($goodsInfo->sales_num + 1);
                        GoodsModel::where('id',$goodsInfo->id)->update(['sales_num' => $salesNum]);
                        echo '支付成功';
                    }
                }
                break;
            case 'buy service':
                break;
            case 'buy shop service':

                break;
        }
    }

    /**
     * 根据订单类型处理微信异步回调逻辑
     *
     * @param $type
     * @param $data
     */
    public function wechatNotifyHandle($type, $data)
    {
        $content = '<xml>
                    <return_code><![CDATA[SUCCESS]]></return_code>
                    <return_msg><![CDATA[OK]]></return_msg>
                    </xml>';

        switch ($type){
            case 'cash':
                $res = OrderModel::where('code', $data['code'])->first();
                if (!empty($res) && $res->status == 0) {
                    $orderModel = new OrderModel();
                    $status = $orderModel->recharge('wechat', $data);
                }
                break;
            case 'pub task':
                break;
            case 'pub goods':
                $data['pay_type'] = 3;
                $shopOrder = ShopOrderModel::where(['code' => $data['code'], 'status' => 0, 'object_type' => 3])->first();
                if (!empty($shopOrder)){
                    $status = ShopOrderModel::thirdBuyShopService($shopOrder->code, $data);
                }
                break;
            case 'pub service':
                break;
            case 'buy goods':
                $data['pay_type'] = 3;
                $res = ShopOrderModel::where(['code'=>$data['code'],'status'=>0,'object_type' => 2])->first();
                if (!empty($res)){
                    $status = ShopOrderModel::thirdBuyGoods($res->code, $data);
                    if ($status) {
                        //查询商品数据
                        $goodsInfo = GoodsModel::where('id',$res->object_id)->first();
                        //修改商品销量
                        $salesNum = intval($goodsInfo->sales_num + 1);
                        GoodsModel::where('id',$goodsInfo->id)->update(['sales_num' => $salesNum]);
                        echo '支付成功';
                    }
                }
                break;
            case 'buy service':
                break;
            case 'buy shop service':

                break;
        }

        if ($status)
            //回复微信端请求成功
            return response($content)->header('Content-Type', 'text/xml');
    }


}
