<?php
/**
 * Created by PhpStorm.
 * User: ge
 * Date: 2019/1/16
 * Time: 下午3:57
 */

include_once "vendor/autoload.php";

$e = \Prometheus\CollectorRegistry::getDefault()
    ->getOrRegisterCounter('', 'some_quick_counter', 'just a quick measurement')
    ->inc();


$registry = \Prometheus\CollectorRegistry::getDefault();

$counter = $registry->getOrRegisterCounter('test', 'some_counter', 'it increases', ['type']);
$counter->incBy(3, ['blue']);

$gauge = $registry->getOrRegisterGauge('test', 'some_gauge', 'it sets', ['type']);
$gauge->set(2.5, ['blue']);

$histogram = $registry->getOrRegisterHistogram('test', 'some_histogram', 'it observes', ['type'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
$histogram->observe(3.5, ['blue']);


$registry = \Prometheus\CollectorRegistry::getDefault();

$renderer = new \Prometheus\RenderTextFormat();
$result = $renderer->render($registry->getMetricFamilySamples());

header('Content-type: ' . \Prometheus\RenderTextFormat::MIME_TYPE);
echo $result;
