<?php

function enviarEmail(){
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.ckpnd.com:5001/v1/email',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "to": [
            {
                "email": "oabreu@botpro.ai"
            }
        ],
        "options": {
            "cc": [
                {
                    "email": "odalisdabreu@gmail.com"
                }
            ]
        },
        "from": {
            "email": "operaciones@segurosexpress.com",
            "name": "Odalis Abreu"
        },
        "replyTo": {
            "email": "operaciones@segurosexpress.com",
            "name": "Odalis Abreu"
        },
        "subject": "Hello World",
        "body": "<h1>Hello World</h1>",
        "attachments": [
            {
                "path": "https://i1.wp.com/cms.babbel.news/wp-content/uploads/2015/05/HEAD02_FRA-20150703094705.gif"
            },
            {
                "path": "http://2.bp.blogspot.com/-DIEPOOz9uqI/UHomvta-AcI/AAAAAAAAAdI/_Nv0WyIXxhA/s1600/P1010411.JPG"
            }
        ]
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer 3f6cad2f.0f9f49318468647529d45efa',
        'Content-Type: application/json'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    echo $response;
}