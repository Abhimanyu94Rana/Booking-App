<?php
return [ 
    'client_id' => 'AXzP6HQnL3uzUOJgS3T5Oc4jbNq5Dr8AAJq1O-9e8krFom1-Eeit8cTqyUsg8VsFcVlDWbbxztS49TlM',
	'secret' => 'EEU7kSh4q_s7HQ9m4W-_ycIAqUifGDKbfuG2TMBCFgROEIsM894XZlrrhstVLXGWBFjVLN66nzFHNKxh',
    'settings' => array(
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => 1000,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE'
    ),
];