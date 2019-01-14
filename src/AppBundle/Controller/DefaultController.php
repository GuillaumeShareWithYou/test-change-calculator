<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Model\Change;
use AppBundle\Registry\CalculatorRegistry;
use AppBundle\Registry\CalculatorRegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @var CalculatorRegistry
     */
    private $calculatorRegistry;

    public function __construct(CalculatorRegistryInterface $calculatorRegistry)
    {
        $this->calculatorRegistry = $calculatorRegistry;
    }

    /**
     * @Route("automaton/{name}/change/{amount}", methods={"GET"}, requirements={"amount"= "\d+"})
     * @param $name
     * @param $amount
     * @return Response
     */
    public function getChange(string $name, int $amount)
    {
        $calculator = $this->calculatorRegistry->getCalculatorFor($name);
        if (null == $calculator) {
            throw new NotFoundHttpException('This automaton is not supported yet.');
        }

        $change = $calculator->getChange($amount);
        $status = $change != null ? 200 : 204;
        return new Response(
            json_encode($change),
            $status,
            ['Content-type' => 'application/json']
        );
    }
}
