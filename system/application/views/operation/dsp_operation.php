<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {if $iAction == 1}Vklad na účet{else}Výběr z účtu{/if} {$oAccount->number} ({$oAccount->type->name})
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
                <form class="form-horizontal" role="form" action="
                    {if $iAction == 1}
                        {site_url('coperation/doDeposit')}/{$oAccount->ID}/{$oPerson->ID}
                    {else}
                        {site_url('coperation/doWithdraw')}/{$oAccount->ID}/{$oPerson->ID}
                    {/if}" method="post"
                >
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Částka</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input1" name="value" placeholder="Částka">
                                    <button type="submit" class="btn btn-success col-md-offset-10">Uložit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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