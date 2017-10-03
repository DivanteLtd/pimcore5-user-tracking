<?php
/**
 * @category    pimcore5-user-tracking
 * @date        26/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */
?>
<h4>Divante Tracking Bundle Configuration</h4>
<form action="<?= $this->path('divante_tracking_config_save') ?>" method="post">
    <div>
        MongoDB username:
        <input type="text" name="username" value="<?= $this->escape($this->config['username']) ?>" style="width:100%;" />
    </div>
    <div>
        MongoDB password:
        <input type="text" name="password" value="<?= $this->escape($this->config['password']) ?>" style="width:100%;" />
    </div>
    <div>
        MongoDB host:
        <input type="text" name="host" value="<?= $this->escape($this->config['host']) ?>" style="width:100%;" />
    </div>
    <div>
        MongoDB port:
        <input type="text" name="port" value="<?= $this->escape($this->config['port']) ?>" style="width:100%;" />
    </div>
    <div>
        MongoDB database:
        <input type="text" name="database" value="<?= $this->escape($this->config['database']) ?>" style="width:100%;" />
    </div>
    <div>
        <input type="submit" value="Submit" />
    </div>
</form>