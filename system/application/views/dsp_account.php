<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Přidat nový účet
                </h3>
            </div>
            <div class="panel-body">
                <!-- BUG: vim, ze ta adresa je blbe, nevim jak ji udelat dobre -->
                <form class="form-horizontal" role="form" action="{site_url('cadvice/createAccount/')}/{$oClient->ID}" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Číslo účtu</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input1" name="number" placeholder="Číslo účtu">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input2" class="col-sm-2 control-label">Klient</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <input readonly required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input2" name="client_name" placeholder="Klient" value="{$oClient->name} {$oClient->surname}">
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input3" class="col-sm-2 control-label">Počáteční vklad</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input3" name="value" placeholder="Zůstatek">
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
                                        {if ! empty($aTypes)}
                                            {foreach $aTypes as $oType}
                                                <option value="{$oType->ID}">{$oType->name}</option>
                                            {/foreach}
                                        {/if}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success col-md-offset-10">Uložit</button>
                    </div>
                </form>
            </div>
<!--                         <div class="panel-footer">
                Panel footer
            </div> -->
        </div>
        
        
    </div>
</div>

