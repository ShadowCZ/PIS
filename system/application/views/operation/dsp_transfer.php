<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Zadání převodu {$oAccount->number} ({$oAccount->type->name})
                </h3>
            </div>
            <div class="panel-body">
                <div class=" col-md-1">
                    <a href="{site_url('coperation/showAccountDetail')}/{$oAccount->ID}/{$oPerson->ID}">
                        <button  class="btn btn-success col-md-offset-1">Zpět</button>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="{site_url('coperation/doTransfer')}/{$oAccount->ID}/{$oPerson->ID}" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Částka</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input1" name="value" placeholder="Částka">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input2" class="col-sm-2 control-label">Číslo účtu</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input2" name="targetAccount" placeholder="Číslo účtu">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input3" class="col-sm-2 control-label">Banka</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input3" name="bank" placeholder="Banka">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input4" class="col-sm-2 control-label">Variabilní symbol</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input4" name="VS" placeholder="Variabilní symbol">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input5" class="col-sm-2 control-label">Specifický symbol</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input5" name="SS" placeholder="Specifický symbol">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input6" class="col-sm-2 control-label">Konstantní symbol</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input6" name="CS" placeholder="Konstantní symbol">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input7" class="col-sm-2 control-label">Zpráva</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input7" name="message" placeholder="Zpráva">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success col-md-offset-10">Uložit</button>
                </form>
            </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                   Detaily účtu
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>
                                Vlastník
                            </th>
                            <th>
                                Disponibilní zůstatek
                            </th>
                            <th>
                                Zůstatek
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{$oAccount->client->name} {$oAccount->client->surname}</td>
                            <td>{$oAccount->availableValue}</td>
                            <td>{$oAccount->value}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                   Pověřená osoba
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>
                                Pověřená osoba
                            </th>
                            <th>
                                K dispozici
                            </th>
                            <th>
                                Limit
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{$oPerson->client->name} {$oPerson->client->surname}</td>
                            <td>{$iAvailableCash}</td>
                            <td>{$oPerson->limit}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</div>
