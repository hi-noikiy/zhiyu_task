<?php

use Illuminate\Database\Seeder;

class MenuPermissionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_permission')->delete();
        
        \DB::table('menu_permission')->insert(array (
            0 => 
            array (
                'id' => 5,
                'menu_id' => 1,
                'permission_id' => 93,
            ),
            1 => 
            array (
                'id' => 6,
                'menu_id' => 106,
                'permission_id' => 98,
            ),
            2 => 
            array (
                'id' => 7,
                'menu_id' => 106,
                'permission_id' => 100,
            ),
            3 => 
            array (
                'id' => 8,
                'menu_id' => 106,
                'permission_id' => 101,
            ),
            4 => 
            array (
                'id' => 9,
                'menu_id' => 68,
                'permission_id' => 103,
            ),
            5 => 
            array (
                'id' => 10,
                'menu_id' => 68,
                'permission_id' => 104,
            ),
            6 => 
            array (
                'id' => 11,
                'menu_id' => 68,
                'permission_id' => 105,
            ),
            7 => 
            array (
                'id' => 12,
                'menu_id' => 68,
                'permission_id' => 106,
            ),
            8 => 
            array (
                'id' => 13,
                'menu_id' => 68,
                'permission_id' => 107,
            ),
            9 => 
            array (
                'id' => 17,
                'menu_id' => 71,
                'permission_id' => 111,
            ),
            10 => 
            array (
                'id' => 18,
                'menu_id' => 90,
                'permission_id' => 112,
            ),
            11 => 
            array (
                'id' => 19,
                'menu_id' => 90,
                'permission_id' => 113,
            ),
            12 => 
            array (
                'id' => 20,
                'menu_id' => 90,
                'permission_id' => 114,
            ),
            13 => 
            array (
                'id' => 21,
                'menu_id' => 90,
                'permission_id' => 115,
            ),
            14 => 
            array (
                'id' => 22,
                'menu_id' => 90,
                'permission_id' => 116,
            ),
            15 => 
            array (
                'id' => 23,
                'menu_id' => 90,
                'permission_id' => 117,
            ),
            16 => 
            array (
                'id' => 24,
                'menu_id' => 90,
                'permission_id' => 118,
            ),
            17 => 
            array (
                'id' => 26,
                'menu_id' => 91,
                'permission_id' => 121,
            ),
            18 => 
            array (
                'id' => 27,
                'menu_id' => 91,
                'permission_id' => 122,
            ),
            19 => 
            array (
                'id' => 28,
                'menu_id' => 91,
                'permission_id' => 123,
            ),
            20 => 
            array (
                'id' => 29,
                'menu_id' => 91,
                'permission_id' => 124,
            ),
            21 => 
            array (
                'id' => 30,
                'menu_id' => 91,
                'permission_id' => 125,
            ),
            22 => 
            array (
                'id' => 31,
                'menu_id' => 93,
                'permission_id' => 126,
            ),
            23 => 
            array (
                'id' => 32,
                'menu_id' => 93,
                'permission_id' => 127,
            ),
            24 => 
            array (
                'id' => 33,
                'menu_id' => 40,
                'permission_id' => 129,
            ),
            25 => 
            array (
                'id' => 34,
                'menu_id' => 40,
                'permission_id' => 131,
            ),
            26 => 
            array (
                'id' => 35,
                'menu_id' => 40,
                'permission_id' => 132,
            ),
            27 => 
            array (
                'id' => 36,
                'menu_id' => 40,
                'permission_id' => 133,
            ),
            28 => 
            array (
                'id' => 37,
                'menu_id' => 91,
                'permission_id' => 120,
            ),
            29 => 
            array (
                'id' => 38,
                'menu_id' => 40,
                'permission_id' => 134,
            ),
            30 => 
            array (
                'id' => 39,
                'menu_id' => 40,
                'permission_id' => 135,
            ),
            31 => 
            array (
                'id' => 40,
                'menu_id' => 56,
                'permission_id' => 136,
            ),
            32 => 
            array (
                'id' => 41,
                'menu_id' => 56,
                'permission_id' => 137,
            ),
            33 => 
            array (
                'id' => 42,
                'menu_id' => 56,
                'permission_id' => 138,
            ),
            34 => 
            array (
                'id' => 43,
                'menu_id' => 56,
                'permission_id' => 139,
            ),
            35 => 
            array (
                'id' => 44,
                'menu_id' => 56,
                'permission_id' => 140,
            ),
            36 => 
            array (
                'id' => 45,
                'menu_id' => 57,
                'permission_id' => 141,
            ),
            37 => 
            array (
                'id' => 46,
                'menu_id' => 57,
                'permission_id' => 142,
            ),
            38 => 
            array (
                'id' => 47,
                'menu_id' => 57,
                'permission_id' => 143,
            ),
            39 => 
            array (
                'id' => 48,
                'menu_id' => 57,
                'permission_id' => 144,
            ),
            40 => 
            array (
                'id' => 49,
                'menu_id' => 57,
                'permission_id' => 145,
            ),
            41 => 
            array (
                'id' => 50,
                'menu_id' => 75,
                'permission_id' => 146,
            ),
            42 => 
            array (
                'id' => 51,
                'menu_id' => 75,
                'permission_id' => 147,
            ),
            43 => 
            array (
                'id' => 52,
                'menu_id' => 75,
                'permission_id' => 148,
            ),
            44 => 
            array (
                'id' => 53,
                'menu_id' => 75,
                'permission_id' => 149,
            ),
            45 => 
            array (
                'id' => 54,
                'menu_id' => 75,
                'permission_id' => 150,
            ),
            46 => 
            array (
                'id' => 55,
                'menu_id' => 75,
                'permission_id' => 151,
            ),
            47 => 
            array (
                'id' => 56,
                'menu_id' => 75,
                'permission_id' => 152,
            ),
            48 => 
            array (
                'id' => 57,
                'menu_id' => 58,
                'permission_id' => 153,
            ),
            49 => 
            array (
                'id' => 58,
                'menu_id' => 58,
                'permission_id' => 154,
            ),
            50 => 
            array (
                'id' => 59,
                'menu_id' => 58,
                'permission_id' => 155,
            ),
            51 => 
            array (
                'id' => 60,
                'menu_id' => 58,
                'permission_id' => 156,
            ),
            52 => 
            array (
                'id' => 61,
                'menu_id' => 58,
                'permission_id' => 157,
            ),
            53 => 
            array (
                'id' => 62,
                'menu_id' => 45,
                'permission_id' => 158,
            ),
            54 => 
            array (
                'id' => 63,
                'menu_id' => 45,
                'permission_id' => 159,
            ),
            55 => 
            array (
                'id' => 64,
                'menu_id' => 45,
                'permission_id' => 160,
            ),
            56 => 
            array (
                'id' => 65,
                'menu_id' => 45,
                'permission_id' => 161,
            ),
            57 => 
            array (
                'id' => 66,
                'menu_id' => 45,
                'permission_id' => 162,
            ),
            58 => 
            array (
                'id' => 67,
                'menu_id' => 105,
                'permission_id' => 163,
            ),
            59 => 
            array (
                'id' => 68,
                'menu_id' => 105,
                'permission_id' => 164,
            ),
            60 => 
            array (
                'id' => 69,
                'menu_id' => 105,
                'permission_id' => 165,
            ),
            61 => 
            array (
                'id' => 70,
                'menu_id' => 105,
                'permission_id' => 166,
            ),
            62 => 
            array (
                'id' => 71,
                'menu_id' => 81,
                'permission_id' => 167,
            ),
            63 => 
            array (
                'id' => 72,
                'menu_id' => 81,
                'permission_id' => 168,
            ),
            64 => 
            array (
                'id' => 73,
                'menu_id' => 81,
                'permission_id' => 169,
            ),
            65 => 
            array (
                'id' => 74,
                'menu_id' => 81,
                'permission_id' => 170,
            ),
            66 => 
            array (
                'id' => 75,
                'menu_id' => 50,
                'permission_id' => 171,
            ),
            67 => 
            array (
                'id' => 76,
                'menu_id' => 50,
                'permission_id' => 172,
            ),
            68 => 
            array (
                'id' => 77,
                'menu_id' => 46,
                'permission_id' => 173,
            ),
            69 => 
            array (
                'id' => 78,
                'menu_id' => 46,
                'permission_id' => 174,
            ),
            70 => 
            array (
                'id' => 79,
                'menu_id' => 46,
                'permission_id' => 175,
            ),
            71 => 
            array (
                'id' => 80,
                'menu_id' => 46,
                'permission_id' => 176,
            ),
            72 => 
            array (
                'id' => 81,
                'menu_id' => 46,
                'permission_id' => 177,
            ),
            73 => 
            array (
                'id' => 82,
                'menu_id' => 46,
                'permission_id' => 178,
            ),
            74 => 
            array (
                'id' => 83,
                'menu_id' => 61,
                'permission_id' => 179,
            ),
            75 => 
            array (
                'id' => 84,
                'menu_id' => 61,
                'permission_id' => 180,
            ),
            76 => 
            array (
                'id' => 85,
                'menu_id' => 61,
                'permission_id' => 181,
            ),
            77 => 
            array (
                'id' => 86,
                'menu_id' => 61,
                'permission_id' => 182,
            ),
            78 => 
            array (
                'id' => 87,
                'menu_id' => 61,
                'permission_id' => 183,
            ),
            79 => 
            array (
                'id' => 88,
                'menu_id' => 61,
                'permission_id' => 184,
            ),
            80 => 
            array (
                'id' => 89,
                'menu_id' => 61,
                'permission_id' => 185,
            ),
            81 => 
            array (
                'id' => 90,
                'menu_id' => 61,
                'permission_id' => 186,
            ),
            82 => 
            array (
                'id' => 91,
                'menu_id' => 60,
                'permission_id' => 187,
            ),
            83 => 
            array (
                'id' => 92,
                'menu_id' => 60,
                'permission_id' => 188,
            ),
            84 => 
            array (
                'id' => 93,
                'menu_id' => 60,
                'permission_id' => 189,
            ),
            85 => 
            array (
                'id' => 94,
                'menu_id' => 60,
                'permission_id' => 190,
            ),
            86 => 
            array (
                'id' => 95,
                'menu_id' => 60,
                'permission_id' => 191,
            ),
            87 => 
            array (
                'id' => 96,
                'menu_id' => 60,
                'permission_id' => 192,
            ),
            88 => 
            array (
                'id' => 97,
                'menu_id' => 60,
                'permission_id' => 193,
            ),
            89 => 
            array (
                'id' => 98,
                'menu_id' => 60,
                'permission_id' => 194,
            ),
            90 => 
            array (
                'id' => 99,
                'menu_id' => 60,
                'permission_id' => 195,
            ),
            91 => 
            array (
                'id' => 100,
                'menu_id' => 79,
                'permission_id' => 196,
            ),
            92 => 
            array (
                'id' => 101,
                'menu_id' => 79,
                'permission_id' => 197,
            ),
            93 => 
            array (
                'id' => 102,
                'menu_id' => 79,
                'permission_id' => 198,
            ),
            94 => 
            array (
                'id' => 103,
                'menu_id' => 79,
                'permission_id' => 199,
            ),
            95 => 
            array (
                'id' => 104,
                'menu_id' => 79,
                'permission_id' => 200,
            ),
            96 => 
            array (
                'id' => 105,
                'menu_id' => 79,
                'permission_id' => 201,
            ),
            97 => 
            array (
                'id' => 106,
                'menu_id' => 79,
                'permission_id' => 202,
            ),
            98 => 
            array (
                'id' => 107,
                'menu_id' => 52,
                'permission_id' => 203,
            ),
            99 => 
            array (
                'id' => 108,
                'menu_id' => 52,
                'permission_id' => 204,
            ),
            100 => 
            array (
                'id' => 109,
                'menu_id' => 52,
                'permission_id' => 205,
            ),
            101 => 
            array (
                'id' => 111,
                'menu_id' => 54,
                'permission_id' => 206,
            ),
            102 => 
            array (
                'id' => 112,
                'menu_id' => 54,
                'permission_id' => 207,
            ),
            103 => 
            array (
                'id' => 113,
                'menu_id' => 54,
                'permission_id' => 208,
            ),
            104 => 
            array (
                'id' => 114,
                'menu_id' => 54,
                'permission_id' => 209,
            ),
            105 => 
            array (
                'id' => 115,
                'menu_id' => 54,
                'permission_id' => 210,
            ),
            106 => 
            array (
                'id' => 116,
                'menu_id' => 53,
                'permission_id' => 211,
            ),
            107 => 
            array (
                'id' => 117,
                'menu_id' => 53,
                'permission_id' => 212,
            ),
            108 => 
            array (
                'id' => 118,
                'menu_id' => 53,
                'permission_id' => 213,
            ),
            109 => 
            array (
                'id' => 119,
                'menu_id' => 53,
                'permission_id' => 214,
            ),
            110 => 
            array (
                'id' => 120,
                'menu_id' => 53,
                'permission_id' => 215,
            ),
            111 => 
            array (
                'id' => 121,
                'menu_id' => 67,
                'permission_id' => 216,
            ),
            112 => 
            array (
                'id' => 122,
                'menu_id' => 67,
                'permission_id' => 217,
            ),
            113 => 
            array (
                'id' => 123,
                'menu_id' => 67,
                'permission_id' => 218,
            ),
            114 => 
            array (
                'id' => 124,
                'menu_id' => 67,
                'permission_id' => 219,
            ),
            115 => 
            array (
                'id' => 125,
                'menu_id' => 67,
                'permission_id' => 220,
            ),
            116 => 
            array (
                'id' => 126,
                'menu_id' => 67,
                'permission_id' => 221,
            ),
            117 => 
            array (
                'id' => 127,
                'menu_id' => 100,
                'permission_id' => 222,
            ),
            118 => 
            array (
                'id' => 128,
                'menu_id' => 100,
                'permission_id' => 223,
            ),
            119 => 
            array (
                'id' => 129,
                'menu_id' => 101,
                'permission_id' => 224,
            ),
            120 => 
            array (
                'id' => 130,
                'menu_id' => 96,
                'permission_id' => 225,
            ),
            121 => 
            array (
                'id' => 131,
                'menu_id' => 97,
                'permission_id' => 226,
            ),
            122 => 
            array (
                'id' => 132,
                'menu_id' => 97,
                'permission_id' => 227,
            ),
            123 => 
            array (
                'id' => 133,
                'menu_id' => 98,
                'permission_id' => 228,
            ),
            124 => 
            array (
                'id' => 134,
                'menu_id' => 98,
                'permission_id' => 229,
            ),
            125 => 
            array (
                'id' => 135,
                'menu_id' => 99,
                'permission_id' => 230,
            ),
            126 => 
            array (
                'id' => 136,
                'menu_id' => 101,
                'permission_id' => 231,
            ),
            127 => 
            array (
                'id' => 137,
                'menu_id' => 103,
                'permission_id' => 232,
            ),
            128 => 
            array (
                'id' => 138,
                'menu_id' => 103,
                'permission_id' => 233,
            ),
            129 => 
            array (
                'id' => 139,
                'menu_id' => 98,
                'permission_id' => 234,
            ),
            130 => 
            array (
                'id' => 140,
                'menu_id' => 97,
                'permission_id' => 235,
            ),
            131 => 
            array (
                'id' => 141,
                'menu_id' => 97,
                'permission_id' => 236,
            ),
            132 => 
            array (
                'id' => 143,
                'menu_id' => 97,
                'permission_id' => 238,
            ),
            133 => 
            array (
                'id' => 144,
                'menu_id' => 38,
                'permission_id' => 239,
            ),
            134 => 
            array (
                'id' => 145,
                'menu_id' => 38,
                'permission_id' => 240,
            ),
            135 => 
            array (
                'id' => 146,
                'menu_id' => 38,
                'permission_id' => 241,
            ),
            136 => 
            array (
                'id' => 147,
                'menu_id' => 38,
                'permission_id' => 242,
            ),
            137 => 
            array (
                'id' => 148,
                'menu_id' => 38,
                'permission_id' => 243,
            ),
            138 => 
            array (
                'id' => 149,
                'menu_id' => 40,
                'permission_id' => 244,
            ),
            139 => 
            array (
                'id' => 150,
                'menu_id' => 40,
                'permission_id' => 245,
            ),
            140 => 
            array (
                'id' => 151,
                'menu_id' => 39,
                'permission_id' => 246,
            ),
            141 => 
            array (
                'id' => 152,
                'menu_id' => 39,
                'permission_id' => 247,
            ),
            142 => 
            array (
                'id' => 153,
                'menu_id' => 43,
                'permission_id' => 248,
            ),
            143 => 
            array (
                'id' => 154,
                'menu_id' => 43,
                'permission_id' => 249,
            ),
            144 => 
            array (
                'id' => 155,
                'menu_id' => 43,
                'permission_id' => 250,
            ),
            145 => 
            array (
                'id' => 156,
                'menu_id' => 43,
                'permission_id' => 251,
            ),
            146 => 
            array (
                'id' => 157,
                'menu_id' => 43,
                'permission_id' => 252,
            ),
            147 => 
            array (
                'id' => 158,
                'menu_id' => 43,
                'permission_id' => 253,
            ),
            148 => 
            array (
                'id' => 159,
                'menu_id' => 44,
                'permission_id' => 254,
            ),
            149 => 
            array (
                'id' => 160,
                'menu_id' => 44,
                'permission_id' => 255,
            ),
            150 => 
            array (
                'id' => 161,
                'menu_id' => 83,
                'permission_id' => 256,
            ),
            151 => 
            array (
                'id' => 162,
                'menu_id' => 83,
                'permission_id' => 257,
            ),
            152 => 
            array (
                'id' => 163,
                'menu_id' => 78,
                'permission_id' => 258,
            ),
            153 => 
            array (
                'id' => 164,
                'menu_id' => 78,
                'permission_id' => 259,
            ),
            154 => 
            array (
                'id' => 165,
                'menu_id' => 78,
                'permission_id' => 260,
            ),
            155 => 
            array (
                'id' => 166,
                'menu_id' => 78,
                'permission_id' => 261,
            ),
            156 => 
            array (
                'id' => 167,
                'menu_id' => 78,
                'permission_id' => 262,
            ),
            157 => 
            array (
                'id' => 168,
                'menu_id' => 78,
                'permission_id' => 263,
            ),
            158 => 
            array (
                'id' => 169,
                'menu_id' => 78,
                'permission_id' => 264,
            ),
            159 => 
            array (
                'id' => 170,
                'menu_id' => 78,
                'permission_id' => 265,
            ),
            160 => 
            array (
                'id' => 171,
                'menu_id' => 77,
                'permission_id' => 266,
            ),
            161 => 
            array (
                'id' => 172,
                'menu_id' => 77,
                'permission_id' => 267,
            ),
            162 => 
            array (
                'id' => 173,
                'menu_id' => 77,
                'permission_id' => 268,
            ),
            163 => 
            array (
                'id' => 174,
                'menu_id' => 77,
                'permission_id' => 269,
            ),
            164 => 
            array (
                'id' => 175,
                'menu_id' => 77,
                'permission_id' => 270,
            ),
            165 => 
            array (
                'id' => 176,
                'menu_id' => 77,
                'permission_id' => 271,
            ),
            166 => 
            array (
                'id' => 177,
                'menu_id' => 77,
                'permission_id' => 272,
            ),
            167 => 
            array (
                'id' => 178,
                'menu_id' => 77,
                'permission_id' => 273,
            ),
            168 => 
            array (
                'id' => 179,
                'menu_id' => 77,
                'permission_id' => 274,
            ),
            169 => 
            array (
                'id' => 180,
                'menu_id' => 77,
                'permission_id' => 275,
            ),
            170 => 
            array (
                'id' => 181,
                'menu_id' => 47,
                'permission_id' => 276,
            ),
            171 => 
            array (
                'id' => 183,
                'menu_id' => 62,
                'permission_id' => 278,
            ),
            172 => 
            array (
                'id' => 184,
                'menu_id' => 106,
                'permission_id' => 99,
            ),
            173 => 
            array (
                'id' => 185,
                'menu_id' => 106,
                'permission_id' => 102,
            ),
            174 => 
            array (
                'id' => 186,
                'menu_id' => 40,
                'permission_id' => 130,
            ),
            175 => 
            array (
                'id' => 187,
                'menu_id' => 92,
                'permission_id' => 279,
            ),
            176 => 
            array (
                'id' => 190,
                'menu_id' => 62,
                'permission_id' => 282,
            ),
            177 => 
            array (
                'id' => 192,
                'menu_id' => 59,
                'permission_id' => 284,
            ),
            178 => 
            array (
                'id' => 193,
                'menu_id' => 64,
                'permission_id' => 285,
            ),
            179 => 
            array (
                'id' => 194,
                'menu_id' => 59,
                'permission_id' => 286,
            ),
            180 => 
            array (
                'id' => 197,
                'menu_id' => 68,
                'permission_id' => 292,
            ),
            181 => 
            array (
                'id' => 198,
                'menu_id' => 64,
                'permission_id' => 293,
            ),
            182 => 
            array (
                'id' => 199,
                'menu_id' => 68,
                'permission_id' => 294,
            ),
            183 => 
            array (
                'id' => 203,
                'menu_id' => 63,
                'permission_id' => 297,
            ),
            184 => 
            array (
                'id' => 206,
                'menu_id' => 102,
                'permission_id' => 237,
            ),
            185 => 
            array (
                'id' => 207,
                'menu_id' => 68,
                'permission_id' => 298,
            ),
            186 => 
            array (
                'id' => 208,
                'menu_id' => 88,
                'permission_id' => 299,
            ),
            187 => 
            array (
                'id' => 209,
                'menu_id' => 85,
                'permission_id' => 300,
            ),
            188 => 
            array (
                'id' => 211,
                'menu_id' => 85,
                'permission_id' => 301,
            ),
            189 => 
            array (
                'id' => 212,
                'menu_id' => 91,
                'permission_id' => 119,
            ),
            190 => 
            array (
                'id' => 214,
                'menu_id' => 1,
                'permission_id' => 303,
            ),
            191 => 
            array (
                'id' => 215,
                'menu_id' => 89,
                'permission_id' => 302,
            ),
            192 => 
            array (
                'id' => 216,
                'menu_id' => 89,
                'permission_id' => 304,
            ),
            193 => 
            array (
                'id' => 217,
                'menu_id' => 89,
                'permission_id' => 305,
            ),
            194 => 
            array (
                'id' => 218,
                'menu_id' => 70,
                'permission_id' => 109,
            ),
            195 => 
            array (
                'id' => 219,
                'menu_id' => 70,
                'permission_id' => 108,
            ),
            196 => 
            array (
                'id' => 220,
                'menu_id' => 63,
                'permission_id' => 283,
            ),
            197 => 
            array (
                'id' => 221,
                'menu_id' => 38,
                'permission_id' => 280,
            ),
            198 => 
            array (
                'id' => 222,
                'menu_id' => 38,
                'permission_id' => 281,
            ),
            199 => 
            array (
                'id' => 223,
                'menu_id' => 62,
                'permission_id' => 277,
            ),
            200 => 
            array (
                'id' => 224,
                'menu_id' => 107,
                'permission_id' => 306,
            ),
            201 => 
            array (
                'id' => 226,
                'menu_id' => 110,
                'permission_id' => 307,
            ),
            202 => 
            array (
                'id' => 227,
                'menu_id' => 112,
                'permission_id' => 308,
            ),
            203 => 
            array (
                'id' => 229,
                'menu_id' => 112,
                'permission_id' => 309,
            ),
            204 => 
            array (
                'id' => 231,
                'menu_id' => 113,
                'permission_id' => 310,
            ),
            205 => 
            array (
                'id' => 232,
                'menu_id' => 113,
                'permission_id' => 311,
            ),
            206 => 
            array (
                'id' => 233,
                'menu_id' => 113,
                'permission_id' => 312,
            ),
            207 => 
            array (
                'id' => 234,
                'menu_id' => 113,
                'permission_id' => 313,
            ),
            208 => 
            array (
                'id' => 235,
                'menu_id' => 114,
                'permission_id' => 314,
            ),
            209 => 
            array (
                'id' => 236,
                'menu_id' => 114,
                'permission_id' => 315,
            ),
            210 => 
            array (
                'id' => 237,
                'menu_id' => 114,
                'permission_id' => 316,
            ),
            211 => 
            array (
                'id' => 238,
                'menu_id' => 115,
                'permission_id' => 317,
            ),
            212 => 
            array (
                'id' => 243,
                'menu_id' => 118,
                'permission_id' => 324,
            ),
            213 => 
            array (
                'id' => 245,
                'menu_id' => 120,
                'permission_id' => 318,
            ),
            214 => 
            array (
                'id' => 246,
                'menu_id' => 120,
                'permission_id' => 319,
            ),
            215 => 
            array (
                'id' => 247,
                'menu_id' => 120,
                'permission_id' => 320,
            ),
            216 => 
            array (
                'id' => 248,
                'menu_id' => 122,
                'permission_id' => 321,
            ),
            217 => 
            array (
                'id' => 249,
                'menu_id' => 121,
                'permission_id' => 326,
            ),
            218 => 
            array (
                'id' => 250,
                'menu_id' => 121,
                'permission_id' => 327,
            ),
            219 => 
            array (
                'id' => 251,
                'menu_id' => 126,
                'permission_id' => 328,
            ),
            220 => 
            array (
                'id' => 252,
                'menu_id' => 126,
                'permission_id' => 329,
            ),
            221 => 
            array (
                'id' => 253,
                'menu_id' => 126,
                'permission_id' => 330,
            ),
            222 => 
            array (
                'id' => 254,
                'menu_id' => 126,
                'permission_id' => 331,
            ),
            223 => 
            array (
                'id' => 255,
                'menu_id' => 126,
                'permission_id' => 332,
            ),
            224 => 
            array (
                'id' => 256,
                'menu_id' => 126,
                'permission_id' => 333,
            ),
            225 => 
            array (
                'id' => 257,
                'menu_id' => 125,
                'permission_id' => 334,
            ),
            226 => 
            array (
                'id' => 258,
                'menu_id' => 125,
                'permission_id' => 335,
            ),
            227 => 
            array (
                'id' => 259,
                'menu_id' => 125,
                'permission_id' => 336,
            ),
            228 => 
            array (
                'id' => 260,
                'menu_id' => 127,
                'permission_id' => 337,
            ),
            229 => 
            array (
                'id' => 261,
                'menu_id' => 127,
                'permission_id' => 338,
            ),
            230 => 
            array (
                'id' => 262,
                'menu_id' => 118,
                'permission_id' => 325,
            ),
            231 => 
            array (
                'id' => 263,
                'menu_id' => 70,
                'permission_id' => 110,
            ),
        ));
        
        
    }
}
