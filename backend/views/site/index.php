<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

  $usuario = ucfirst(Yii::$app->user->identity->nombres). " ". ucfirst(Yii::$app->user->identity->apellidos);


$this->title = '¡Bienvenido (a) '. $usuario. "!";
?>

