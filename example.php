<?php

require_once('waveform.php');

$data 		= array(0.00979614,0.0212708,0.0258484,0.0361633,0.0321045,0.0260925,0.195251,0.118988,0.161713,0.250366,0.230225,0.255249,0.186066,0.182159,0.192719,0.254883,0.250671,0.246674,0.179901,0.13324,0.18573,0.223999,0.163513,0.185913,0.171417,0.217987,0.219543,0.262268,0.207397,0.188019,0.138916,0.169342,0.167053,0.128998,0.130219,0.140411,0.181976,0.147125,0.170227,0.195892,0.155884,0.222076,0.244202,0.226288,0.207642,0.205261,0.197601,0.22818,0.182648,0.177887,0.232544,0.190521,0.27298,0.197144,0.289856,0.165436,0.156555,0.194611,0.21759,0.774536,0.807404,0.752747,0.734619,0.677704,0.826019,0.824554,0.753723,0.294495,0.765137,0.180237,0.816925,0.675934,0.784058,0.721893,0.356903,0.822815,0.668274,0.763031,0.70874,0.69809,0.706818,0.737061,0.767151,0.710114,0.671082,0.793793,0.782654,0.775574,0.642334,0.736389,0.438446,0.782623,0.333069,0.752502,0.732483,0.665192,0.774872,0.827606,0.747131,0.775696,0.70401,0.788483,0.81189,0.761993,0.355194,0.796082,0.345428,0.764465,0.661682,0.795013,0.739532,0.485443,0.779816,0.755829,0.69101,0.774719,0.651917,0.756226,0.81842,0.753662,0.765137,0.696167,0.803925,0.801941,0.734253,0.509094,0.805969,0.413818,0.826599,0.300751,0.79776,0.756317,0.651245,0.767487,0.740448,0.778076,0.727722,0.689362,0.786591,0.744202,0.800537,0.450317,0.737549,0.458618,0.795471,0.243347,0.748444,0.749146,0.627045,0.810822,0.739349,0.774445,0.766937,0.816833,0.816772,0.757416,0.793549,0.792725,0.769653,0.815735,0.761993,0.740723,0.668732,0.721039,0.566681,0.794525,0.512085,0.799561,0.764252,0.69339,0.79068,0.809479,0.827576,0.877472,0.680145,0.790833,0.843506,0.735229,0.479492,0.745972,0.250732,0.808105,0.316223,0.784912,0.763397,0.453094,0.794617,0.78125,0.780884,0.770233,0.624084,0.790833,0.779205,0.786896,0.758209,0.699371,0.765564,0.707581,0.74707,0.452911,0.74527,0.475708,0.834229,0.235016,0.78775,0.755524,0.745758,0.801514,0.796539,0.783508,0.727539,0.647369,0.772766,0.751373,0.737854,0.542603,0.772766,0.410828,0.804352,0.287109,0.73111,0.723755,0.511688,0.7883,0.64566,0.790161,0.743164,0.687347,0.704163,0.84314,0.778046,0.790039,0.705566,0.766632,0.774261,0.701538,0.638641,0.767853,0.512543,0.836639,0.421082,0.713593,0.792419,0.647095,0.802277,0.793884,0.77356,0.728882,0.691254,0.809357,0.810547,0.799469,0.430756,0.749542,0.326477,0.813873,0.291077,0.74704,0.739777,0.461151,0.811066,0.776855,0.757568,0.757385,0.713196,0.810272,0.818726,0.75946,0.795776,0.729889,0.725067,0.749664,0.755798,0.747009,0.797485,0.557495,0.912415,0.359802,0.78009,0.757294,0.661407,0.763489,0.789917,0.730377,0.693787,0.678284,0.785492,0.76297,0.766327,0.440155,0.722961,0.388367,0.80368,0.336243,0.738098,0.731323,0.517792,0.804352,0.744904,0.758148,0.779846,0.670441,0.739014,0.794037,0.725616,0.724091,0.68811,0.740448,0.779541,0.744873,0.379425,0.753876,0.267273,0.785339,0.507721,0.730499,0.785004,0.738861,0.743774,0.717529,0.792175,0.760468,0.743591,0.798706,0.731323,0.772766,0.358826,0.771118,0.388489,0.801147,0.580841,0.742096,0.806854,0.503601,0.765228,0.749817,0.735229,0.714325,0.76236,0.706299,0.748383,0.749695,0.757477,0.669861,0.784119,0.763458,0.750336,0.445007,0.744507,0.510193,0.777924,0.395599,0.775574,0.730804,0.743622,0.703247,0.726074,0.768829,0.830292,0.656769,0.741852,0.841034,0.766144,0.586945,0.751404,0.660583,0.775116,0.629852,0.773499,0.8255,0.695984,0.811829,0.71582,0.805847,0.736206,0.749603,0.69281,0.777588,0.772491,0.793701,0.7258,0.760101,0.815948,0.761383,0.590393,0.717926,0.401154,0.797333,0.585419,0.751129,0.74704,0.774963,0.760437,0.806244,0.809875,0.797974,0.631714,0.752777,0.794342,0.73999,0.465424,0.740082,0.514526,0.793274,0.496796,0.79776,0.756012,0.625244,0.799866,0.774689,0.748932,0.781555,0.815125,0.802277,0.761444,0.724609,0.721466,0.743256,0.701508,0.802002,0.747772,0.603516,0.736481,0.598846,0.769806,0.607819,0.790375,0.715393,0.652557,0.721283,0.71225,0.786346,0.752258,0.674011,0.734558,0.741821,0.792938,0.552338,0.806976,0.621643,0.807281,0.667969,0.697906,0.802002,0.790375,0.798798,0.789246,0.709473,0.77774,0.683258,0.789886,0.756561,0.779968,0.74057,0.742004,0.78595,0.768005,0.759705,0.511169,0.759399,0.451752,0.845764,0.580261,0.779083,0.827759,0.775574,0.796234,0.760406,0.766357,0.72403,0.671234,0.798187,0.786377,0.74646,0.594025,0.70578,0.394684,0.812988,0.316467,0.823914,0.693878,0.698944,0.821777,0.781006,0.748627,0.719971,0.656311,0.832855,0.826385,0.76236,0.736786,0.643829,0.780457,0.798584,0.776215,0.597687,0.731537,0.468048,0.780731,0.43692,0.762177,0.737701,0.658478,0.718109,0.791809,0.79837,0.728302,0.66156,0.813538,0.757324,0.748627,0.429413,0.776001,0.331116,0.758484,0.289825,0.741913,0.740173,0.64801,0.783356,0.788452,0.775421,0.707428,0.699707,0.699432,0.773621,0.772705,0.709167,0.757172,0.792389,0.757263,0.761536,0.632965,0.699036,0.248077,0.818085,0.57962,0.764893,0.686462,0.701935,0.744385,0.828949,0.801208,0.724701,0.758789,0.764465,0.806061,0.75766,0.525085,0.732056,0.362854,0.864227,0.709503,0.679535,0.765045,0.631042,0.792206,0.770447,0.797455,0.756622,0.749817,0.820923,0.769257,0.734833,0.726929,0.62735,0.78006,0.788696,0.800568,0.526306,0.749512,0.621246,0.727814,0.582001,0.775543,0.824219,0.740265,0.312866,0.168243,0.065155,0.0726929,0.0690308,0.766571,0.803436,0.737183,0.516205,0.781769,0.463745,0.765594,0.579132,0.739075,0.751312,0.62674,0.736298,0.714111,0.766571,0.76297,0.744232,0.838959,0.795593,0.729309,0.814911,0.650757,0.789856,0.723969,0.792511,0.666901,0.764191,0.540314,0.718292,0.615845,0.80719,0.754272,0.613678,0.761536,0.726837,0.808197,0.81366,0.635742,0.721588,0.807312,0.739441,0.622742,0.786499,0.506836,0.704224,0.66684,0.786438,0.759033,0.616974,0.770721,0.796753,0.784821,0.755188,0.629669,0.764343,0.697723,0.742279,0.733643,0.744812,0.804749,0.763763,0.752167,0.692322,0.74292,0.546814,0.780548,0.756836,0.764893,0.726471,0.654724,0.773041,0.720856,0.793732,0.802643,0.730988,0.722015,0.765472,0.760406,0.492615,0.747192,0.53183,0.78363,0.691467,0.761475,0.77121,0.587463,0.707703,0.741516,0.806488,0.742279,0.697632,0.831329,0.756256,0.743958,0.737823,0.727386,0.773834,0.724884,0.742462,0.485107,0.719177,0.780579,0.812714,0.762115,0.824127,0.811676,0.71933,0.712463,0.762024,0.765228,0.77005,0.853119,0.813171,0.74527,0.799011,0.687408,0.791779,0.745544,0.83194,0.807098,0.77887,0.774231,0.77655,0.78833,0.784058,0.79895,0.765564,0.745575,0.799194,0.826508,0.76593,0.683411,0.766846,0.74881,0.746307,0.74469,0.748718,0.743744,0.71875,0.761292,0.771759,0.842773,0.757385,0.670868,0.48819,0.792389,0.627655,0.809509,0.548584,0.772491,0.712708,0.715729,0.679108,0.728302,0.706207,0.789185,0.718903,0.827057,0.729797,0.729095,0.749268,0.766602,0.723846,0.776489,0.766602,0.607605,0.815765,0.796661,0.762177,0.762329,0.731476,0.71582,0.771393,0.732269,0.80661,0.704224,0.729584,0.674896,0.78894,0.756653,0.768982,0.756378,0.838409,0.772095,0.712433,0.763428,0.81488,0.808228,0.795959,0.79657,0.770569,0.765778,0.770355,0.771637,0.775574,0.139832,0.134827,0.130646,0.0928955,0.088562,0.0585632,0.0486755,0.0409241,0.0295715,0.0371094,0.0276794,0.0247498,0.0233154,0.0182495,0.015625,0.00958252,0.00424194,0.00292969,0.00128174,0.00012207,0,0);
$options 	= array('data' => $data, 'innerColor' => '#ffffff', 'outerColor' => '#f25d55', 'width' => 400, 'height' => 80);

$waveform 	= new Waveform($options);
$waveform->createWaveform();
$waveform->toImage('test.png');

?>