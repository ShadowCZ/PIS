<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {if $iAction == 1}Vklad na účet{else}výběr z účtu{/if} {$oAccount->number}
                </h3>
            </div>
            <div class="panel-body">
                <div class=" col-md-1">
                    <a href="{site_url('coperation/showAccountDetail')}/{$oAccount->ID}/{$oPerson->ID}">
                        <button  class="btn btn-success col-md-offset-1">Zpět</button>
                    </a>
                </div>

                <!-- BUG: vim, ze ta adresa je blbe, nevim jak ji udelat dobre -->
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
<!--                         <div class="panel-footer">
                Panel footer
            </div> -->
        </div>
        
        
    </div>
</div>



{$oAccount->type->name}
{$oAccount->client->name} {$oAccount->client->surname}
{$oAccount->value}
{$oAccount->availableValue}
        
{$oPerson->ID}
{$oPerson->client->name} {$oPerson->client->surname}
{$iAvailableCash} / {$oPerson->limit}