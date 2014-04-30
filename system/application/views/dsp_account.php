<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Detail účtu
                </h3>
            </div>
            <div class="panel-body">
                <!-- BUG: vim, ze ta adresa je blbe, nevim jak ji udelat dobre -->
                <form class="form-horizontal" role="form" action="{site_url('cadvice/updateAccount/')}{if $oAccount->ID}/{$oAccount->ID}{/if}" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" name="ID" value="{if $oAccount->ID}{$oAccount->ID}{/if}">
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Číslo účtu</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input1" name="number" placeholder="Číslo účtu" value="{if $oAccount->number}{$oAccount->number}{/if}">
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
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input8" name="value" placeholder="Zůstatek" value="{if $oAccount->value}{$oAccount->value}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input9" class="col-sm-2 control-label">Klient</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="input9" name="client">
                                        {if ! empty($aClient)}
                                            {foreach $aClient as $oClient}
                                                <option value="{$oClient->ID}" {if $oAccount->ID && $oClient->ID == $oAccount->role} selected="selected"{/if}>{$oClient->surname}</option>
                                            {/foreach}
                                        {/if}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label required title="Toto pole je potřeba vyplnit." for="input11" class="col-sm-2 control-label">Disponibilní zůstatek</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input11" name="avaibleValue" placeholder="Disponibilní zůstatek" value="{if $oAccount->avaibleValue}{$oAccount->avaibleValue}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label required title="Toto pole je potřeba vyplnit." for="input10" class="col-sm-2 control-label">Typ</label>
                                <div class="col-sm-10">
                                     <select class="form-control" id="input10" name="type">
                                        {if ! empty($aType)}
                                            {foreach $aType as $oType}
                                                <option value="{$oType->ID}" {if $oAccount->ID && $oType->ID == $oAccount->role} selected="selected"{/if}>{$oType->name}</option>
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
<!--                         <div class="panel-footer">
                Panel footer
            </div> -->
        </div>
        
        
    </div>
</div>

