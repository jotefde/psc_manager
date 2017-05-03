<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>PSCManager by JoteFDe</title>
    </head>
    <body>
        <pre>
        <?php
         require_once 'PSCM/pscmanager.php';
         PSCManager::init();
         var_dump(199/100);
        ?>
        </pre>
        
        <?php
        if( isset($_POST["send_transaction"]) ):
            require_once PSCM_DIR.'payment_redirect.php';
        else:
        ?>
        
        <form id="pscm_form" action="" method="POST">
            <label for="pscm_merchant" class="pscm_form_label">
                <b>Your's account login:</b>
                <input type="text" maxlength="32" name="pscm_merchant" class="pscm_form_input" placeholder="ei. yoda19" required>
            </label>
            <label for="pscm_offer" class="pscm_form_label">
                <b>Select an offer:</b>
                <select name="pscm_offer" class="pscm_form_input">
                <?php
                for( $i=0; $i < PSCManager::count(); $i++ ):
                    $offer = PSCManager::getByIndex($i);

                ?>
                    <option value="<?= $offer->ID() ?>">
                        <?= $offer->Description() ?> | <?= $offer->Price() ?>
                        <?= PSCManager::prop('api_currency') ?>
                    </option>
                <?php
                endfor;
                ?>
                </select>
            </label>
            <input type="submit" value="Pay" name="send_transaction">
        </form>
        
        <?php
        endif;
        ?>
    </body>
</html>
