<?php

namespace br\com\cf\library\core\payment\adapters;

use br\com\cf\library\core\payment\Payable,
    br\com\cf\Bootstrap

;

/**
 *
 * @author Michael F. Rodrigues
 */
class AdapterPagSeguro implements Payable
{

    /**
     * 
     */
    public function getPaymentRequest ()
    {
        return new \PagSeguroPaymentRequest();
    }

    /**
     * 
     */
    public function getAccountCredentials ($email, $token)
    {
        return new \PagSeguroAccountCredentials($email, $token);
    }

    /**
     * 
     */
//    public function get

    /**
     * @return void
     */
    private function __construct ()
    {
        define('PAGSEGURO_LIBRARY', TRUE);

        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroTransaction.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroTransactionType.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroTransactionStatus.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroPaymentMethod.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroPaymentMethodType.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroPaymentMethodCode.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/parser/PagSeguroServiceParser.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/parser/PagSeguroTransactionParser.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/service/PagSeguroTransactionSearchService.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroNotificationType.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/exception/PagSeguroServiceException.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/log/LogPagSeguro.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroHttpStatus.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/utils/PagSeguroXmlParser.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/helper/PagSeguroHelper.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/service/PagSeguroPaymentService.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/service/PagSeguroConnectionData.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/utils/PagSeguroHttpConnection.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/parser/PagSeguroPaymentParserData.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/parser/PagSeguroPaymentParser.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/config/PagSeguroConfig.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroPaymentRequest.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroCredentials.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroError.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroAccountCredentials.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroShippingType.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroShipping.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroAddress.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroSender.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroPhone.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/domain/PagSeguroItem.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/resources/PagSeguroResources.class.php");
        require_once (CF_APP_LIBRARY_PATH . "/pagseguro/PagSeguroLibrary.php");
    }

    public static function printPaymentUrl ($url)
    {
        if ($url) {
            echo "<h2>Criando requisição de pagamento</h2>";
            echo "<p>URL do pagamento: <strong>$url</strong></p>";
            echo "<p><a title=\"URL do pagamento\" href=\"$url\">Ir para URL do pagamento.</a></p>";
        }
    }

    /**
     * @return AdapterPagSeguro
     */
    public static function factory ()
    {
        return new self();
    }

}