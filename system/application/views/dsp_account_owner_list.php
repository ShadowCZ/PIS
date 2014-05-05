<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    ! dopnit Detail účtu
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" >
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
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input8" class="col-sm-2 control-label">Zůstatek</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input8" name="value" placeholder="Zůstatek" value="{if $oAccount->value}{$oAccount->value}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input9" class="col-sm-2 control-label">Klient</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input9" name="xxx" placeholder="Jméno" value="{if $oAccount->client->name}{$oAccount->client->name} {$oAccount->client->surname}{/if}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label required title="Toto pole je potřeba vyplnit." for="input11" class="col-sm-5 control-label">Disponibilní zůstatek</label>
                                <div class="col-sm-7">
                                    <input readonly type="text" class="form-control" id="input11" name="availableValue" placeholder="Disponibilní zůstatek" value="{if $oAccount->availableValue}{$oAccount->availableValue}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label required title="Toto pole je potřeba vyplnit." for="input10" class="col-sm-5 control-label">Typ</label>
                                <div class="col-sm-7">
                                     <input readonly type="text" class="form-control" id="input10" name="availableValue" placeholder="Disponibilní zůstatek" value="{if $oAccount->type}{$oAccount->type->name}{/if}">
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
                    Pověřené osoby
                </h3>
            </div>
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
                    </tr>
                </thead>
                <tbody>
                    {foreach $aPersons as $oPerson}
                        <tr class='clickableRow'
                            {if $type == 0}
                                href="{site_url('ctransaction/showTransferList')}//{if $iClient}{$iClient}{else}0{/if}/{if $iAccount}{$iAccount}{else}0{/if}/{if $fromDate}{$fromDate}{/if}/{if $toDate}{$toDate}{/if}"
                            {else}
                                href="{site_url('ctransaction/showOperationList')}//{if $iClient}{$iClient}{else}0{/if}/{if $iAccount}{$iAccount}{else}0{/if}/{if $fromDate}{$fromDate}{/if}/{if $toDate}{$toDate}{/if}"
                            {/if}>
                            <td>
                                {$oPerson->ID}
                            </td>
                            <td>
                                {$oPerson->client->name} {$oPerson->client->surname}
                            </td>
                            <td>
                                {$oPerson->limit}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
              
        
    </div>
</div>

