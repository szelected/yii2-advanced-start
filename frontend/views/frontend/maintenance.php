<?php

use yii\helpers\Html;
use frontend\widgets\timer\CountDown;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

$this->title = $name;
$date = new DateTime('22-02-2020 12:00:00');
$timestamp = $date->getTimestamp();
?>

<h1><?= Html::encode($this->title) ?></h1>
<p><?= $message ?></p>

<?= CountDown::widget([
    'status' => true,
    'clientOptions' => [
        'timestamp' => $timestamp,
    ]
]) ?>
