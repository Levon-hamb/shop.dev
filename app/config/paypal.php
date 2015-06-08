<?php
return array(
    // set your paypal credential
    'client_id' => 'Ae7uBbtieZBwevTskOeci9MOjaI2IqYr5esCeojOpoOChh_F4LsvURozVSA8XGinHSPUwyKvq54nic4w',
    'secret' => 'EMLGYBIru-VU_gn5jK86XjDlwXV8rWFW38hRChqUov0qciIRv0kqfp3aP8-77iw0SgvJXZdYiNVN7bOl',

    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);