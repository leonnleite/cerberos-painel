<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract,
    br\com\cf\library\core\validation\Validation as v,
    br\com\cf\library\core\uploader\Uploader,
    br\com\cf\library\core\payment\Payment,
    br\com\cf\library\core\session\Session,
    br\com\cf\library\core\message\Message,
    br\com\cf\library\core\jasper\Jasper,
    br\com\cf\library\core\gantt\Project,
    br\com\cf\library\core\email\Email,
    br\com\cf\library\core\gantt\Gantt,
    br\com\cf\library\core\gantt\Task,
    br\com\cf\library\core\hash\Hash,
    br\com\cf\library\core\auth\Auth,
    br\com\cf\Bootstrap

;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerIndex extends ControllerAbstract {

    /**
     * @return void
     */
    public function indexAction() {

        if (!Auth::isAuthenticated()) {
            $this->forward('Usuario', 'formAuth');
        }

        $view = Session::get('user')->fg_perfil == 1 ? 'admin' : 'user';

        $this->setView('index', $view)
                ->set('background', '/img/wallpaper.jpg')
                ->set('nm_usuario', current(explode(' ', Session::get('user')->nm_usuario)))
                ->render();
    }

    /**
     * @return void
     */
    public function clienteAction() {
        $this->setView('index', 'cliente')->render();
    }

    /**
     * @todo Test
     * @return void
     */
    public function jasperAction() {
        try {
            Jasper::factory()
                    ->setParams(array("id_usuario" => $this->getParam('id_usuario')))
                    ->setJrXml(CF_APP_BASE_PATH . "/br/com/cf/jrxml/lme.jrxml")
                    ->beginDB()
                    ->output('I');
        } catch (\Exception $e) {
            print($e->getMessage());
        }
    }

    /**
     * @todo Test
     * @return void
     */
    public function respectAction() {

        try {
            /**
             * Exemplo 1
             */
            $nome = 'Michael';

            $convidadoValidador = v::alnum()
                    ->noWhitespace()
                    ->length(1, 15);


            var_dump($convidadoValidador->validate($nome));

            /**
             * Exemplo 2
             */
            $numero = '123';

            var_dump(v::numeric()->validate($numero));

            /**
             * Exemplo 3
             */
            $user = new \stdClass;
            $user->name = 'Michael';
            $user->birthdate = '1987-11-12';
            $user->email = 'cerberosnash@gmail.com';
            $userValidator = v::attribute('name', v::string()->length(1, 32))
                    ->attribute('birthdate', v::date()->minimumAge(64))
                    ->attribute('email', v::string()->email());

            var_dump($userValidator->validate($user)); //true

            $userValidator->assert('#name');

            /**
             * Exemplo 4
             */
            var_dump(v::not(v::int())->validate(10)); //false, input must not be integer

            /**
             * Exemplo 5
             */
            $numero = 255;

            var_dump(v::numeric()->positive()->between(1, 256)->validate($numero));

            /**
             * Exemplo 6
             */
            var_dump(v::cpf()->validate('642.987.322-66'));
            var_dump(v::cpf()->validate('64298732266'));
        } catch (\Respect\Validation\Exceptions\AllOfException $e) {

            $errors = $e->findMessages(array(
                'alnum' => '{{name}} must contain only letters and digits',
                'length' => '{{name}} must not have more than 15 chars',
                'noWhitespace' => '{{name}} cannot contain spaces',
                'email' => 'O campo {{name}} está inválido!'
            ));
            var_dump($errors);
        }
    }

    /**
     * @todo Test Email
     * @return void
     */
    public function emailAction() {
        try {
            set_time_limit(15);
            ini_set('memory_limit', '32M');

            Email::factory()
                    ->isSMTP()
                    ->addAddress('cerberosnash@gmail.com', 'Michael F. Rodrigues')
                    ->from('cerberosnash@gmail.com', 'Michael F. Rodrigues')
                    ->message('<a>Clique aqui para pagar...</a>')
                    ->subject('ASSUNTO')
                    ->send()
            ;
        } catch (\Exception $e) {
            print($e->getMessage());
        }
    }

    /**
     * Test Message
     * @todo
     */
    public function messageAction() {
        print Message::getMessage($this->getParam('message'));
    }

    /**
     * Test Clean
     * @todo
     */
    public function cleanCacheAction() {
        if ($handle = opendir(CF_APP_CACHE_PATH)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') {
                    unlink(CF_APP_CACHE_PATH . '/' . $file);
                }
            }
        }
        print('Cache limpo com sucesso!');
    }

    /**
     * Test PaymentRequest
     * @todo
     */
    public function paymentRequestAction() {

        $cfg = Bootstrap::factory()->getConfig();

        $paymentAdapter = Payment::factory($cfg->getParam('payment.defaultPaymentType'));

        $paymentRequest = $paymentAdapter->getPaymentRequest();
        $paymentRequest->setCurrency("BRL");
        $paymentRequest->addItem('0001', 'Voucher Test Pagamento', 1, 1.00);
        $paymentRequest->setReference("REF1234");

        $CODIGO_SEDEX = \PagSeguroShippingType::getCodeByType('SEDEX');

        $paymentRequest->setShippingType($CODIGO_SEDEX);
        $paymentRequest->setShippingAddress('01452002', 'Av. Brig. Faria Lima', '1384', 'apto. 114', 'Jardim Paulistano', 'São Paulo', 'SP', 'BRA');
        $paymentRequest->setSender('Michael Fernandes Rodrigues', 'cerberosnash@gmail.com', '61', '91455842');
        $paymentRequest->setRedirectUrl("http://www.lojamodelo.com.br");

        try {

            $credentials = $paymentAdapter->getAccountCredentials(
                    $cfg->getParam('payment.defaultPaymentUser'), $cfg->getParam('payment.defaultPaymentToken')
            );

            print sprintf("<a href='%s' target='_blank'>Clique aqui para efetuar o pagamento...</a>", $paymentRequest->register($credentials));
        } catch (\PagSeguroServiceException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Test PaymentRequest
     * @todo
     */
    public function paymentReturnAction() {
        $file = CF_APP_CACHE_PATH . '/paymentReturn.js';

        file_put_contents($file, file_get_contents($file) . print_r($_REQUEST, true));
    }

    /**
     * Test notificationListenerAction
     * @todo
     */
    public function notificationListenerAction() {

        $paymentAdapter = Payment::factory('pagseguro');

        $code = (($this->getParam('notificationCode')) && trim($this->getParam('notificationCode')) !== "" ? trim($this->getParam('notificationCode')) : null);
        $type = (($this->getParam('notificationType')) && trim($this->getParam('notificationType')) !== "" ? trim($this->getParam('notificationType')) : null);

        if ($code && $type) {

            $notificationType = new \PagSeguroNotificationType($type);
            $strType = $notificationType->getTypeFromValue();

            switch ($strType) {

                case 'TRANSACTION':
                    $credentials = new PagSeguroAccountCredentials("cerberosnash@gmail.com", "TOKEN_PAGSEGURO");

                    try {
                        $transaction = PagSeguroNotificationService::checkTransaction($credentials, $code);
                    } catch (\PagSeguroServiceException $e) {
                        print($e->getMessage());
                    }
                    break;

                default:
                    \LogPagSeguro::error("Unknown notification type [" . $notificationType->getValue() . "]");
            }
        } else {

            \LogPagSeguro::error("Invalid notification parameters.");
//            self::printLog();
        }
    }

    /**
     * Test searchTransactionByCodeAction
     * @todo
     */
    public function searchTransactionByCodeAction() {
        $paymentAdapter = Payment::factory('pagseguro');

        $transaction_code = 'DA83F7BB-7466-442C-B7BF-708BD1DD158A';

        try {

            /*
             * #### Crendencials ##### 
             * Substitute the parameters below with your credentials (e-mail and token)
             * You can also get your credentails from a config file. See an example:
             * $credentials = PagSeguroConfig::getAccountCredentials();
             */
            $credentials = $paymentAdapter->getAccountCredentials("cerberosnash@gmail.com", "TOKEN_PAGSEGURO");

            $transaction = \PagSeguroTransactionSearchService::searchByCode($credentials, $transaction_code);

            echo "<h2>Transaction search by code result";
            echo "<h3>Code: " . $transaction->getCode() . '</h3>';
            echo "<h3>Status: " . $transaction->getStatus()->getTypeFromValue() . '</h3>';
            echo "<h4>Reference: " . $transaction->getReference() . "</h4>";

            if ($transaction->getSender()) {
                echo "<h4>Sender data:</h4>";
                echo "Name: " . $transaction->getSender()->getName() . '<br>';
                echo "Email: " . $transaction->getSender()->getEmail() . '<br>';
                if ($transaction->getSender()->getPhone()) {
                    echo "Phone: " . $transaction->getSender()->getPhone()->getAreaCode() . " - " . $transaction->getSender()->getPhone()->getNumber();
                }
            }

            if ($transaction->getItems()) {
                echo "<h4>Items:</h4>";
                if (is_array($transaction->getItems())) {
                    foreach ($transaction->getItems() as $key => $item) {
                        echo "Id: " . $item->getId() . '<br>'; // prints the item id, p.e. I39
                        echo "Description: " . $item->getDescription() . '<br>'; // prints the item description, p.e. Notebook prata
                        echo "Quantidade: " . $item->getQuantity() . '<br>'; // prints the item quantity, p.e. 1
                        echo "Amount: " . $item->getAmount() . '<br>'; // prints the item unit value, p.e. 3050.68
                        echo "<hr>";
                    }
                }
            }

            if ($transaction->getShipping()) {
                echo "<h4>Shipping information:</h4>";
                if ($transaction->getShipping()->getAddress()) {
                    echo "Postal code: " . $transaction->getShipping()->getAddress()->getPostalCode() . '<br>';
                    echo "Street: " . $transaction->getShipping()->getAddress()->getStreet() . '<br>';
                    echo "Number: " . $transaction->getShipping()->getAddress()->getNumber() . '<br>';
                    echo "Complement: " . $transaction->getShipping()->getAddress()->getComplement() . '<br>';
                    echo "District: " . $transaction->getShipping()->getAddress()->getDistrict() . '<br>';
                    echo "City: " . $transaction->getShipping()->getAddress()->getCity() . '<br>';
                    echo "State: " . $transaction->getShipping()->getAddress()->getState() . '<br>';
                    echo "Country: " . $transaction->getShipping()->getAddress()->getCountry() . '<br>';
                }
                echo "Shipping type: " . $transaction->getShipping()->getType()->getTypeFromValue() . '<br>';
                echo "Shipping cost: " . $transaction->getShipping()->getCost() . '<br>';
            }
        } catch (\PagSeguroServiceException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Test searchTransactionsByDateIntervalAction
     * @todo
     */
    public function searchTransactionsByDateIntervalAction() {
        print('searchTransactionsByDateIntervalAction');
    }

    /**
     * Test searchTransactionsAbandonedAction
     * @todo
     */
    public function searchTransactionsAbandonedAction() {
        print('searchTransactionsAbandonedAction');
    }

    /**
     * Test searchTransactionsAbandonedAction
     * @todo
     */
    public function enderecoAction() {

        include (CF_APP_LIBRARY_PATH . '/phpquery/phpQuery.php');

        $ch = curl_init('http://m.correios.com.br/movel/buscaCepConfirma.do?metodo=buscarCep&cepEntrada=' . $this->getParam('cep'));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, "10.197.32.60:8080");
        curl_setopt($ch, CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "73762385149:fk9SC");

        \phpQuery::newDocumentHTML(curl_exec($ch), 'utf-8');


        if (strlen(trim(pq('.erro:eq(0)')->html())) == 0) {
            $address = array(
                'logradouro' => trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
                'bairro' => trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
                'cidade/uf' => trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
                'cep' => trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
            );

            $address['cidade/uf'] = explode('/', $address['cidade/uf']);
            $address['cidade'] = trim($address['cidade/uf'][0]);
            $address['uf'] = trim($address['cidade/uf'][1]);

            unset($address['cidade/uf']);

            $response = array('status' => 'success', 'message' => 'CEP Válido', 'endereco' => $address);
        } else {
            $response = array('status' => 'error', 'message' => 'CEP Inválido!');
        }

        $this->json($response);
    }

    /**
     * Test Cpf WebService
     * @todo
     */
    public function cpfAction() {

        $ch = curl_init('http://api.develman.com/receita/cpf.dm?xml&v=' . $this->getParam('numero'));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, "10.197.32.60:8080");
        curl_setopt($ch, CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "73762385149:fk9SC");

        print sprintf("<div class='alert alert-info'>%s</div>", print_r(curl_exec($ch), 1));
    }

    /**
     * Test encrypt
     * @todo
     */
    public function encryptAction() {

        $key = Bootstrap::factory()->getConfig()->getParam('config.hash');
        $password = $this->getParam('password');
        $encrypt = Hash::encrypt($password, $key);

        print sprintf('<div class="alert"><h3>Chave Privada<h3><h2>%s</h2></div>'
                        . '<div class="alert alert-success"><h3>Original<h3><h2>%s</h2></div>'
                        . '<div class="alert alert-danger"><h3>Criptografada<h3><h2>%s</h2></div>', $key, $password, $encrypt);
    }

    /**
     * Test decrypt
     * @todo
     */
    public function decryptAction() {

        $key = Bootstrap::factory()->getConfig()->getParam('config.hash');
        $hash = $this->getParam('hash');
        $decrypt = Hash::decrypt($hash, $key);

        print sprintf('<div class="alert"><h3>Chave Privada<h3><h2>%s</h2></div>'
                        . '<div class="alert alert-danger"><h3>Criptrografada<h3><h2>%s</h2></div>'
                        . '<div class="alert alert-success"><h3>Descriptrograda<3><h2>%s</h2></div>', $key, $hash, $decrypt);
    }

    /**
     * Test checkout project
     * @todo
     */
    public function checkoutAction() {
        if (PHP_OS != 'WINNT') {
            print shell_exec(sprintf("svn update --force %s/*", CF_APP_BASE_PATH));
        }
    }

    /**
     * Test Tmp
     * @todo
     */
    public function manterAgendaAction() {
        $this->setView('tmp', 'manterAgenda')->render();
    }

    /**
     * Test Tmp
     * @todo
     */
    public function salvarAgendaAction() {

        $dias = $this->getParam('dia');
        $horarios = $this->getParam('horario');
        $enderecos = $this->getParam('endereco');

        foreach ($enderecos as $endereco => $value) {
            foreach ($dias as $dia => $value) {
                foreach ($horarios as $horario => $value) {
                    print "ENDERECO :: {$endereco} -> DIA :: -> {$dia} HORARIO :: -> {$horario} <br>";
                }
            }
        }
    }

    /**
     * Test Tmp
     * @todo
     */
    public function formUploadAction() {
        $this->setView('tmp', 'upload')->render();
    }

    /**
     * Test Upload
     * @todo
     */
    public function uploadAction() {

        try {
            $copier = $movier = array();

            $uploader = Uploader::factory()->register(
                    $this->getRequestFiles()
            );

            $registed = $uploader->getPaths();

            foreach ($registed as $key => $file) {
                $copier[] = array($file['name'], CF_APP_TMP_PATH . '/repo/' . rand(1, 20));
            }

            foreach ($registed as $key => $file) {
                $movier[] = array($file['name'], CF_APP_TMP_PATH . '/repo/' . rand(1, 20));
            }

            $uploader->copy($copier)->move($movier)->clean();
        } catch (\Exception $e) {
            print($e->getMessage());
        }
    }

    /**
     * @todo Test
     */
    public function testModelAbstractAction() {
        $model = \br\com\cf\app\model\ModelProduto::factory();

        $tmpl = "<br><h2>%s</h2><fieldset>%s</fieldset><hr><br><br>";

        /**
         * Insert
         */
        $id = $model->insert(array(
            'nm_produto' => 'Produto ' . rand(0, 15454),
            'vl_produto' => rand(0, 15454) . '.00',
            'st_ativo' => rand(0, 1)
        ));

        echo sprintf($tmpl, 'Insert::', $id);

        /**
         * Update
         */
        $model->update(array(
            'id_produto' => $id - 1,
            'nm_produto' => 'Produto Atualizado ' . rand(0, 100),
            'vl_produto' => '100.00',
            'st_ativo' => 3
        ));

        echo sprintf($tmpl, 'Update::', print_r($id, true));

        /**
         * Delete
         */
        echo sprintf($tmpl, 'Delete::', $model->delete($id - 4));

        /**
         * Find
         */
        echo sprintf($tmpl, 'Find::', print_r($model->find($id), true));

        /**
         * FindAll
         */
        echo sprintf($tmpl, 'FindAll::', print_r($model->findAll(0, 4), true));

        /**
         * Partials
         */
        echo sprintf($tmpl, 'Partials::', \br\com\cf\library\core\view\View::partials('edit'));
        \br\com\cf\library\core\view\View::partials('edit');
    }

    /**
     * @todo Test
     */
    public function iniAction() {
        $usuarios = \br\com\cf\app\model\ModelMunicipio::factory()->textual($this->getParam('tag'));

        foreach ($usuarios as $key => $value) {
            printf('Municipio => %s %s<br>', $value['nm_municipio'], $value['rank']);
        }
    }

    /**
     * @todo Test
     */
    public function tramiteAction() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        /**
         * @return integer
         * @param integer $current
         */
        function root($current, $root = NULL) {

            $selected = \br\com\cf\app\model\ModelUnidade::factory('corp')->find($current);

            return ($selected->superior > 0) ? root($selected->superior, $root) : $selected->id;
        }

        /**
         * 
         */
        function childrens($parent) {
            $childrens = \br\com\cf\app\model\ModelUnidade::factory('corp')->childrens($parent);
            $aux = array();
            if (count($childrens) > 0) {
                foreach ($childrens as $children) {
                    $aux[$children->id] = $children;
                    $aux[$children->id]->childrens = childrens($children->id);
                }
            }
            return $aux;
        }

        /**
         * 
         */
        function make($tree, $selected, $root = true) {
            $content = '';

            $ul = '<ul class="explorer1">%s</ul>';
            $il = '<li class="explorer2 %s"><input class="checkboxTreeTramite" type="checkbox" value="%d">%s</li>';

            if ($root) {
                $content .= sprintf($ul, sprintf($il, '', $tree->id, "{$tree->nome} - {$tree->sigla}"));
            }

            foreach ($tree->childrens as $object) {

                if (!$root) {
                    $content .= sprintf($il, ($selected == $object->id) ? 'explorer-selected' : '', $object->id, "{$object->nome} - {$object->sigla}");
                }

                if (count($object->childrens) > 0) {
                    $content .= sprintf($ul, make($object, $selected, false));
                }
            }

            return sprintf($ul, $content);
        }

        /**
         * Root
         */
        $root = root(433);

        $tree = \br\com\cf\app\model\ModelUnidade::factory('corp')->find($root);
        $tree->childrens = childrens($root);

        $this->setView('tmp', 'tramite')
                ->set('tree', make($tree, 338))
                ->render();
    }

    /**
     * Database
     */
    public function databaseAction() {
        /**
         * Find
         */
//        $user1 = \br\com\cf\app\model\ModelUsuario::factory('default')->findAll();
//        $municipios = \br\com\cf\app\model\ModelMunicipio::factory('geo')->findAll(0, 10);
//        $unidades = \br\com\cf\app\model\ModelUnidade::factory('corp')->findAll(0, 10);
//
//        foreach ($municipios as $u) {
//            printf("%d - %s<br>", $u->sq_municipio, $u->nm_municipio);
//        }
//
//        print ('<br><br>');
//
//        foreach ($unidades as $u) {
//            printf("%d - %s<br>", $u->id, $u->nome);
//        }

        /**
         * Update
         */
//        print \br\com\cf\app\model\ModelMunicipio::factory('geo')->update(array(
//                    'sq_municipio' => 5365,
//                    'nm_municipio' => 'Recanto City!'
//                ));
//
//
//        print \br\com\cf\app\model\ModelUnidade::factory('corp')->update(array(
//                    'id' => 1,
//                    'nome' => 'Recanto City!'
//                ));

        /**
         * Delete
         */
//        print \br\com\cf\app\model\ModelMunicipio::factory('geo')->delete(5365);
//        print \br\com\cf\app\model\ModelUnidade::factory('corp')->delete(1);

        /**
         * Insert
         */
        $transaction = \br\com\cf\app\model\ModelVenda::factory()->beginTransaction();

        print \br\com\cf\app\model\ModelVenda::factory()->insert(array(
                    'id_usuario' => 64,
                    'dt_venda' => '2012-01-01',
                    'vl_total' => 1,
                    'st_ativo' => 1
        ));
//
        $transaction->commit();

        $transaction = \br\com\cf\app\model\ModelVenda::factory()->beginTransaction();

        print \br\com\cf\app\model\ModelUsuario::factory()->insert(array(
                    'nm_usuario' => 'string' . rand(0, 10000),
                    'nu_cpf' => 'string' . rand(0, 10000),
                    'fg_perfil' => 'integer',
                    'tx_email' => 'email' . rand(0, 10000),
                    'tx_senha' => 'string' . rand(0, 10000),
                    'st_ativo' => 'boolean'
        ));

        $transaction->commit();
    }

    /**
     * @todo Test Logger
     */
    public function loggerAction() {
        $log = \br\com\cf\library\core\logger\Logger::factory();

//        $log = new KLogger("log.txt", KLogger::INFO);
        $log->LogInfo("Returned a million search results"); //Prints to the log file
        $log->LogFATAL("Oh dear.");    //Prints to the log file
        $log->LogDebug("x = 5");
    }

    /**
     * @todo Test Auth
     */
    public function testAuthAction() {
        $usuario = Auth::factory()->autheticate(array(
            'tx_email' => 'cerberosnash@gmail.com',
            'tx_senha' => md5('123456'),
        ));

        var_dump($usuario);
    }

    /**
     * 
     */
    public function gridAction() {
        $this->setView('tmp', 'datatable')->render();
    }

    /**
     * @todo Test Grid
     */
    public function gridPostgresAction() {
        #Test Postgres
        $query = 'public.produto p inner join segmento s on s.sq_segmento = p.sq_segmento';

        $grid = \br\com\cf\library\core\grid\Grid::factory('geo')
                ->primary('sq_produto')
                ->columns(array(
                    0 => array('p.sq_produto::text' => 'sq_produto'),
                    1 => array('p.nm_produto' => 'nm_produto'),
                    2 => array('s.nm_segmento' => 'nm_segmento')
                ))
                ->query($query)
//                ->group('p.nm_produto')
                ->params($this->getParams())
                ->make()
                ->output()
        ;
        $this->json($grid);
    }

    /**
     * 
     */
    public function gridMysqlAction() {
        #Test Mysql!
        $query = 'usuario u';

        $grid = \br\com\cf\library\core\grid\Grid::factory()
                ->primary('id_usuario')
                ->columns(array(
                    0 => array('u.id_usuario' => 'id_usuario'),
                    1 => array('u.nm_usuario' => 'nm_usuario')
                ))
                ->query($query)
//                ->group('u.id_usuario')
                ->params($this->getParams())
                ->make()
                ->output()
        ;

        $this->json($grid);
    }

    /**
     * 
     */
    public function ganttAction() {

        $project1 = Project::factory(1, 'Violencia', '2013-01-14');

        $project1->addTask(
                        Task::factory('11', '1.1', '2013-01-15', '24', 10, '')
                        ->addTask(
                                Task::factory('111', '1.1.1', '2013-01-15', '12', 100, ''))
                        ->addTask(
                                Task::factory('112', '1.1.2', '2013-01-15', '11', 65, '')
                                ->addTask(
                                        Task::factory('1121', '1.1.2.1', '2013-01-16', '1', 45, '')
                                )
                        )
                )
                ->addTask(
                        Task::factory('12', '1.2', '2013-01-19', '48', 55, '')
                )
                ->addTask(
                        Task::factory('13', '1.3', '2013-01-25', '72', 65, '112')
                )
        ;

        $project2 = Project::factory(2, 'Sociedade', '2013-05-12');

        $project2->addTask(
                Task::factory('21', '2.1', '2013-05-12', '48', 22, '')
        )
        ;

        $project3 = Project::factory(3, 'League of Legends', '2013-03-01');

        $project3->addTask(
                        Task::factory('31', '3.1', '2013-03-02', '12', 75, '')
                )
                ->addTask(
                        Task::factory('32', 'Mobilizacao Social', '2013-03-04', '24', 0, '31')
                )
        ;

        $this->setView('index', 'gantt')
                ->set('gantt', Gantt::factory('targetGanttChartControl')
                        ->addProject($project1)
                        ->addProject($project2)
                        ->addProject($project3)
                        ->render()
                )->render();
    }

}