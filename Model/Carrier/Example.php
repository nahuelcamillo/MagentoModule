<?php
namespace Nahuel\bdayfreeshipping\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;

class Example extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'example';
    protected $_session;
    const DATE_INTERNAL_FORMAT = 'yyyy-MM-dd';

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Magento\Customer\Model\Session $session,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->_session = $session;
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return ['example' => $this->getConfigData('name')];
    }

    /**
     * @param RateRequest $request
     * @return bool|Result
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        if ($this->_session->isLoggedIn()) {
            // Customer is logged in
            $DateOfBirth = $this->_session->getCustomer()->getDob(); // yDob->getDob();
            /*
            * ¿En qué formato trae la fecha?
            * La trae yyyy-mm-d o yyyy-mm-dd (depende si el día empieza con 0 o supera el 10, respectivamente)
            */

            $vecDob = explode("-", $DateOfBirth);
            $today = date("m/j");
            list($Month, $Day) = explode("/", $today);

            /*
            * Lo que se hace acá es lo siguiente:
            * Chequea que la fecha de cumpleaños (mes y día) obtenida sea la misma que el día actual (mes y día).
            * Si la fecha es la misma, debería copiar todo lo que está abajo y poner el valor 0 en el config.xml
            * En caso que no sea la misma, no hacer nada.
            */

            if($vecDob[1] == $Month && $vecDob[2] == $Day) {
              /** @var \Magento\Shipping\Model\Rate\Result $result */
              $result = $this->_rateResultFactory->create();

              /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
              $method = $this->_rateMethodFactory->create();

              $method->setCarrier('example');
              $method->setCarrierTitle($this->getConfigData('title'));

              $method->setMethod('example');
              $method->setMethodTitle($this->getConfigData('name'));

              /*you can fetch shipping price from different sources over some APIs, we used price from config.xml - xml node price*/
              $amount = $this->getConfigData('price');

              $method->setPrice($amount);
              $method->setCost($amount);

              $result->append($method);

              return $result;
            }
        } else {
            // Customer is not logged in
        }

        ///** @var \Magento\Shipping\Model\Rate\Result $result */
        //$result = $this->_rateResultFactory->create();

        ///** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
        //$method = $this->_rateMethodFactory->create();

        //$method->setCarrier('example');
        //$method->setCarrierTitle($this->getConfigData('title'));

        //$method->setMethod('example');
        //$method->setMethodTitle($this->getConfigData('name'));

        ///*you can fetch shipping price from different sources over some APIs, we used price from config.xml - xml node price*/
        //$amount = $this->getConfigData('price');

        //$method->setPrice($amount);
        //$method->setCost($amount);

        //$result->append($method);

        //return $result;
    }
}
