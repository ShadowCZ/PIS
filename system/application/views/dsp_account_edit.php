<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu.php"}
    </div>
    <div class="col-md-9 column">
        <ol class="breadcrumb">
            <li> <a href="{site_url('/cadvice/showClientList')}">Klienti</a></li>
            <li> <a href="{site_url('/cadvice/showAccountList')}">Účty</a></li>
            <li class="active">Editace</li>
        </ol>
        {include file="./block/dsp_message.php"}
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Editace účtu
                </h3>
            </div>
            <div class="panel-body">
                <!-- BUG: vim, ze ta adresa je blbe, nevim jak ji udelat dobre -->
                <form class="form-horizontal" role="form" action="{site_url('cadvice/updateAccount/')}{if $oAccount->ID}/{$oAccount->ID}{/if}" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <input readonly type="hidden" class="form-control" name="ID" value="{if $oAccount->ID}{$oAccount->ID}{/if}">
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Číslo účtu</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input1" name="number" placeholder="Číslo účtu" value="{if $oAccount->number}{$oAccount->number}{/if}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input2" class="col-sm-5 control-label">Klient</label>
                                <div class="col-sm-7">
                                    <input readonly required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input2" name="client_name" placeholder="Klient" value="{if $oAccount->client}{$oAccount->client->name} {$oAccount->client->surname}{/if}">                              
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input3" class="col-sm-2 control-label">Zůstatek</label>
                                <div class="col-sm-10   ">
                                    <input readonly required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input3" name="value" placeholder="Zůstatek" value="{if $oAccount->value}{$oAccount->value}{/if}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label required title="Toto pole je potřeba vyplnit." for="input4" class="col-md-5 control-label">Disponibilní zůstatek</label>
                                <div class="col-md-7">
                                    <input readonly type="text" class="form-control" id="input4" name="avaibleValue" placeholder="Disponibilní zůstatek" value="{if $oAccount->availableValue}{$oAccount->availableValue}{/if}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label required title="Toto pole je potřeba vyplnit." for="input5" class="col-sm-2 control-label">Typ</label>
                                <div class="col-sm-10">
                                     <select class="form-control" id="input5" name="type">
                                        {if ! empty($aType)}
                                            {foreach $aType as $oType}
                                                <option value="{$oType->ID}" {if $oAccount->ID && $oType->ID == $oAccount->type} selected="selected"{/if}>{$oType->name}</option>
                                            {/foreach}
                                        {/if}
                                    </select>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <button type="submit" class="btn btn-success col-md-offset-10">Uložit</button>
                </form>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Nastavení pověřených osob
                </h3>
            </div>
            <div class="panel-body">
                <form role="form" action="{site_url('cadvice/updateDelegatedPersons/')}" method="post">
                    <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Klient
                            </th>
                            <th>
                                Limit
                            </th>
                            <th class="col-md-1">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $aPersons}
                            {foreach $aPersons as $oPerson}
                                <tr>
                                    <td>
                                        {$oPerson->ID}
                                    </td>
                                    <td>
                                        {$oPerson->client->name} {$oPerson->client->surname}
                                    </td>
                                    <td>
                                        <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" name="limit[{$oPerson->ID}]" placeholder="Limit" value="{$oPerson->limit}">
                                    </td>
                                  
                                    <td class="dont-select">
                                        <a href="{site_url('cadvice/removeDelegatedPerson')}/{$oPerson->ID}">
                                            <button type="button" class="btn btn-danger btn-md">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        </a>
                                    </td>
                                </tr>                            
                            {/foreach}
                        {/if}
                    </tbody>
                    </table>
                    <button type="submit" class="btn btn-success col-md-offset-10">Uložit</button>
                </form>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Pověřit osobu
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="{site_url('cadvice/addDelegatedPerson/')}/{$oAccount->ID}" method="post">
                    <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Klient
                            </th>
                            <th>
                                Limit
                            </th>
                            <th class="col-md-1">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $aClients}
                        <tr>
                            <td>
                                <span class="glyphicon glyphicon-plus"></span>
                            </td>
                            <td>
                                <select class="form-control" name="newPerson">
                                    <option> ------- </option>
                                    {foreach $aClients as $oClient}
                                        <option value="{$oClient->ID}">{$oClient->name} {$oClient->surname}</option>
                                    {/foreach}
                                </select>
                            </td>
                            <td>
                                <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" name="newLimit" placeholder="Limit">
                            </td>
                          
                            <td class="dont-select">
                                <button type="submit" class="btn btn-success btn-md">
                                        <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </td>
                        </tr>
                        {/if}
                    </tbody>
                </table>
                </form>
            </div>
<!--                         <div class="panel-footer">
                Panel footer
            </div> -->
        </div>
        
        
    </div>
</div>

