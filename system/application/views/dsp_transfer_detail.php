<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Detail transakce  
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Klient</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." 
                                    type="text" class="form-control" id="input1" value="{if $oOperation->delegatedPerson}{$oOperation->delegatedPerson->client->name} {$oOperation->delegatedPerson->client->surname}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input2" class="col-sm-2 control-label">Banka</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." 
                                    type="text" class="form-control" id="input1" value="{if $oOperation->bank}{$oOperation->bank}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">VS</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." 
                                    type="text" class="form-control" id="input1" value="{if $oOperation->VS}{$oOperation->VS}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">SS</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." 
                                    type="text" class="form-control" id="input1" value="{if $oOperation->SS}{$oOperation->SS}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Zpráva</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." 
                                    type="text" class="form-control" id="input1" value="{if $oOperation->message}{$oOperation->message}{/if}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Klient</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." 
                                    type="text" class="form-control" id="input1" value="{if $oOperation->employee}{$oOperation->employee->name} {$oOperation->employee->surname}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Číslo účtu</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." 
                                    type="text" class="form-control" id="input1" value="{if $oOperation->targetAccount}{$oOperation->targetAccount}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">CS</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." 
                                    type="text" class="form-control" id="input1" value="{if $oOperation->CS}{$oOperation->CS}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Stav</label>
                                <div class="col-sm-10">
                                    <input readonly required title="Toto pole je potřeba vyplnit." 
                                    type="text" class="form-control" id="input1" value="{if $oOperation->state}{$oOperation->state}{/if}">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-md-6 text-right">
                    <a href="{site_url('ctransaction/doAcceptTransfer')}/{if $iClient}{$iClient}{else}0{/if}/{if $iAccount}{$iAccount}{else}0{/if}/{if $fromDate}{$fromDate}{else}0{/if}/{if $toDate}{$toDate}{else}0{/if}/{$oOperation->ID}">
                        <button type="button" class="btn btn-success btn-lg">
                            Potvrdit převod
                        </button>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{site_url('ctransaction/doRejectTransfer')}/{if $iClient}{$iClient}{else}0{/if}/{if $iAccount}{$iAccount}{else}0{/if}/{if $fromDate}{$fromDate}{else}0{/if}/{if $toDate}{$toDate}{else}0{/if}/{$oOperation->ID}">
                        <button type="button" class="btn btn-danger btn-lg">
                            Zamítnout převod
                        </button>
                    </a>
                </div>
            </div>
        </div>
        
        </div>
<!--                         <div class="panel-footer">
                Panel footer
            </div> -->
        </div>
        
        
    </div>
</div>

