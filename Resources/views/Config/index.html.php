<?php
/**
 * @category    pimcore5-user-tracking
 * @date        26/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */

$this->extend('DivanteTrackingBundle::layout.html.php');
?>
<div class="container" style="margin-top: 5%;">
    <h4>Divante Tracking Bundle Configuration</h4>
    <form action="<?= $this->path('divante_tracking_config_save') ?>" method="post">
        <div class="row">
            <div class="six columns">
                <label for="username">MongoDB username</label>
                <input id="username" class="u-full-width" type="text" name="username" value="<?= $this->escape($this->config['username']) ?>">
            </div>
        </div>
        <div class="row">
            <div class="six columns">
                <label for="password">MongoDB password</label>
                <input id="password" class="u-full-width" type="text" name="password" value="<?= $this->escape($this->config['password']) ?>">
            </div>
        </div>
        <div class="row">
            <div class="six columns">
                <label for="host">MongoDB host</label>
                <input id="host" class="u-full-width" type="text" name="host" value="<?= $this->escape($this->config['host']) ?>">
            </div>
        </div>
        <div class="row">
            <div class="six columns">
                <label for="port">MongoDB port</label>
                <input id="port" class="u-full-width" type="text" name="port" value="<?= $this->escape($this->config['port']) ?>">
            </div>
        </div>
        <div class="row">
            <div class="six columns">
                <label for="database">MongoDB database</label>
                <input id="database" class="u-full-width" type="text" name="database" value="<?= $this->escape($this->config['database']) ?>">
            </div>
        </div>
        <div>
            <input class="button-primary" type="submit" value="Submit">
        </div>
    </form>
</div>