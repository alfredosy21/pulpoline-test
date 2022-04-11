<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inicio - PulpoLine</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <?php echo Html::style('https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,300;0,600;0,900;1,700&family=Rubik:wght@500&display=swap') ?>
        <!-- Bootstrap css-->
        <?php echo Html::style('css/bootstrap.min.css') ?>
    </head>
    <body >
        <section class="panel-purple">
            <!---Header ---->
            <div class="header-nav">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <span id="btn-toogle" class="btn-toogle"></span>
                            <div class="logo">
                                <a href="/">
                                    <img src="https://pulpoline.com/wp-content/uploads/2020/09/Logo-PulpoLine_Mesa-de-trabajo-1.png" alt="PulpoLine">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9 hidden-xs">
                        </div>
                    </div>
                </div>
            </div>
            <!---End Header--->
            <!---Panel convert --->
            <div class="container">
                <div class="panel panel-default">
                    <div class="panel-header">
                        Convert
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo url('convert'); ?>" method="GET" id="form">
                            <div class="row">
                                <!------- Error Messages --------->
                                @if(isset($error))
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error ?>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @if(!isset($limit))
                            <div class="row">
                                <!------- Amount Input --------->
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="text" name="amount" id="amount" placeholder="Enter amount" class="form-control"
                                               value="<?php echo isset($amount) ? $amount : ''; ?>">
                                    </div>
                                </div>
                                <!------- End Amount Input --------->
                                <!------- From Input --------->
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label>From</label>
                                        <select class="form-control" name="from" id="from">
                                            @foreach($currencies as $rs)
                                            <option value="<?php echo $rs->id; ?>"
                                                    @if(isset($from) && $from == $rs->id)
                                                selected="selected"
                                                @endif
                                                > 
                                                <?php echo $rs->id; ?> - <?php echo $rs->currencyName; ?>
                                            </option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!------- End From Input --------->
                                <!------- Exchange --------->
                                <div class="col-md-2 col-sm-2 col-xs-12 text-center">
                                    <span class="btn-circle" id="up">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 17" aria-hidden="true" class="miscellany___StyledIconSwap-sc-1r08bla-1 fZJuOo">
                                        <path fill="currentColor" fill-rule="evenodd" d="M11.726 1.273l2.387 2.394H.667V5h13.446l-2.386 2.393.94.94 4-4-4-4-.94.94zM.666 12.333l4 4 .94-.94L3.22 13h13.447v-1.333H3.22l2.386-2.394-.94-.94-4 4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </div>
                                <!------- End Exchange  --------->
                                <!------- To Input --------->
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label>To</label>
                                        <select class="form-control" name="to" id="to">
                                            @foreach($currencies as $rs)
                                            <option value="<?php echo $rs->id; ?>"
                                                    @if(isset($to) && $to == $rs->id)
                                                selected="selected"
                                                @endif
                                                >
                                                <?php echo $rs->id; ?> - <?php echo $rs->currencyName; ?>
                                            </option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!---- End To Input ------->
                                @if(isset($total) && isset($currency))
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h3>Total: <?php echo number_format($total * $amount, 2, '.', ''); ?> <?php echo $currency->currencyName; ?> </h3>
                                    <p> 1 <?php echo $from; ?> = <?php echo number_format($total, 2, '.', ''); ?> <?php echo $to; ?></p>
                                </div>
                                @endif
                                <!------- Info --------->
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <div class="alert alert-primary" role="alert">
                                        We use the mid-market rate for our Converter. This is for informational purposes only. You won’t receive this rate when sending money. Check send rates
                                    </div>
                                </div>
                                <!------- End Info--------->
                                <!------- Buttom --------->
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <button type="submit" class="btn btn-block btn-primary-1">Convert</button>
                                </div>
                                <!------- End Button----->
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End panel convert-->
    </section>
    <!-- Jquery-->
    <?php echo Html::script('js/jquery.min.js') ?>
    <!-- Bootstrap-->
    <?php echo Html::script('js/bootstrap.min.js') ?>
    <!-- Scripts-->
    <?php echo Html::script('js/script.js') ?>
</body>
</html>