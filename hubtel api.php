<?php

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(($_POST['moneyNumber'] != '') && ($_POST['network'] != '') && ($_POST['amount'] != '')) {
        if(isset($_POST['token'])){
            if($_POST['token']  != '') {
                $receive_momo_request = array(
                    'CustomerName' => 'jesse',
                    'CustomerMsisdn' => $_POST['moneyNumber'],
                    'Channel' => $_POST['network'],
                    'Amount' => $_POST['amount'],
                    'PrimaryCallbackUrl' => 'https://yellowpagesgh.com/order',
                    'SecondaryCallbackUrl' => 'https://yellowpagesgh.com/order',
                    'token' => $_POST['token'],
                    'Description' => 'Purchased!',
                );
            }
            else{
                $receive_momo_request = array(
                    'CustomerName' => 'jesse',
                    'CustomerMsisdn' => $_POST['moneyNumber'],
                    'Channel' => $_POST['network'],
                    'Amount' => $_POST['amount'],
                    'PrimaryCallbackUrl' => 'https://yellowpagesgh.com/order',
                    'SecondaryCallbackUrl' => 'https://yellowpagesgh.com/order',
                    'Description' => 'Purchased!',
                );
            }
        }
        else{
            $receive_momo_request = array(
                'CustomerName' => 'jesse',
                'CustomerMsisdn' => $_POST['moneyNumber'],
                'Channel' => $_POST['network'],
                'Amount' => $_POST['amount'],
                'PrimaryCallbackUrl' => 'https://yellowpagesgh.com/order',
                'SecondaryCallbackUrl' => 'https://yellowpagesgh.com/order',
                'Description' => 'Purchased!',
            );
        }

//API Keys
        $clientId = 'kD51KV0';
        $clientSecret = 'f989bcdc-a463-4d24-823c-e681f7e05bf6';
        $basic_auth_key = 'Basic ' . base64_encode($clientId . ':' . $clientSecret);
        $request_url = 'https://api.hubtel.com/v1/merchantaccount/merchants/HM1805170016/receive/mobilemoney';
        $receive_momo_request = json_encode($receive_momo_request);

        $ch = curl_init($request_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $receive_momo_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . $basic_auth_key,
            'Cache-Control: no-cache',
            'Content-Type: application/json',
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            $message =  'oops something went wrong! please try again';
        } else {
            $array = json_decode($result,true);
            if($array['ResponseCode']== "0001"){
                $array['ResponseCode'];
                $message = 'We have sent you a prompt message on your phone, Now you can proceed with transaction.';
            }
            if(isset($array['Errors'][0]['Messages'][0])){
                $message = $array['Errors'][0]['Messages'][0];
            }
            //print_r($array['Errors'][0]['Field']);
        }
    }
    else{
        $message = 'One or more fields are empty or invalid';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body{
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
        .formBox{
            /*margin-top: 90px;
            padding: 50px;*/
        }
        .formBox  h1{
            margin: 0;
            padding: 0;
            text-align: center;
            margin-bottom: 50px;
            text-transform: uppercase;
            font-size: 30px;
        }
        .inputBox{
            position: relative;
            box-sizing: border-box;
            margin-bottom: 50px;
        }
        .inputBox .inputText{
            position: absolute;
            font-size: 30px;
            line-height: 50px;
            transition: .5s;
            opacity: .5;
        }
        .inputBox .input{
            position: relative;
            width: 100%;
            height: 100px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 30px;
            border-bottom: 1px solid rgba(0,0,0,.5);

        }
        .focus .inputText{
            transform: translateY(-30px);
            font-size: 21px;
            opacity: 1;
            color: #00bcd4;

        }
        textarea{
            height: 100px !important;
        }
        .button{
            width: 100%;
            height: 60px;
            border: none;
            outline: none;
            background: #03A9F4;
            color: #fff;
        }
        .col-sm-12{
            padding-right: 0;
            padding-left: 0;
        }
    </style>
</head>
<body>
<div class="">
    <div class="">
        <div class="formBox">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="">
                    <div class="col-sm-12">
                        <h1>order Easy With Your Mobile Wallet</h1>
                    </div>
                </div>

                <div class="col-sm-12">
                    <?php if($message != ''){ ?>
                        <div class="alert alert-info">
                            <strong>Alert! </strong> <?php echo $message; ?>
                        </div>
                    <?php } ?>
                    <div class="col-sm-12">
                        <div class="inputBox ">
                            <div class="inputText">Enter Your Mobile Money Number</div>
                            <input type="text" name="moneyNumber" class="input">
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="col-sm-12">
                        <div class="inputBox">
                            <select class="input" name="network" id="network">
                                <option value="">Select Mobile Money Network</option>
                                <option value="mtn-gh">MTN</option>
                                <option value="airtel-gh">Airtel</option>
                                <option value="tigo-gh">Tigo</option>
                                <option value="vodafone-gh">Vodafone</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="col-sm-12">
                        <div class="inputBox ">
                            <div class="inputText">Enter Amount</div>
                            <input type="text" name="amount" class="input">
                        </div>
                    </div>
                </div>

                <div id="tokenDiv">
                </div>
                <div class="">
                    <div class="col-sm-12">
                        <input type="submit" name="" class="button" value="Submit Now">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(".input").focus(function() {
        $(this).parent().addClass("focus");
    });
    $("#network").change(function(){
        if($("#network").val() == 'vodafone-gh'){
            $("#tokenDiv").html('');
            $("#tokenDiv").append('<div class="col-sm-12"> <div class="inputBox "> <div class="inputText">Enter Your Vodafone token</div> <input type="text" name="token" class="input" /> </div> </div>');
        }else{
            $("#tokenDiv").html('');
        }
        $(".input").focus(function() {
            $(this).parent().addClass("focus");
        });
    });
</script>
</body>
</html>