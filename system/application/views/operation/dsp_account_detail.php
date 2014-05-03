<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Účet {$oAccount->number}
                </h3>
            </div>
            <div class="panel-body">
                <div class=" col-md-1">
                    <a href="{site_url('coperation/showOperation')}/{$oAccount->ID}/{$oPerson->ID}/1">
                        <button  class="btn btn-success col-md-offset-1">Vklad</button>
                    </a>
                </div>
                <div class=" col-md-1">
                    <a href="{site_url('coperation/showOperation')}/{$oAccount->ID}/{$oPerson->ID}/2">
                        <button  class="btn btn-success col-md-offset-1">Výběr</button>
                    </a>
                </div>
                <div class=" col-md-1">
                    <a href="{site_url('cadvice/showTransfer')}/{$oAccount->ID}/{$oPerson->ID}">
                        <button  class="btn btn-success col-md-offset-1">Převod</button>
                    </a>
                </div>
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

{foreach $aOperations as $oOperation}
    {$oOperation->ID}
    {$oOperation->delegatedPerson->client->name} {$oOperation->delegatedPerson->client->surname}
    {$oOperation->employee->name} {$oOperation->employee->surname}
    {$oOperation->type->name}
    {$oOperation->date} (v db změněn na timestamp, nezapomeň aktualizovat db připraveným skriptem)
    {$oOperation->value}

    {if $oOperation->type->ID < 3}
        Výběry/vklady (stejná šablona)
        
    {else}
        Převody
        mají navíc tyto atributy
        {$oOperation->targetAccount}
        {$oOperation->bank}
        {$oOperation->VS}
        {$oOperation->SS}
        {$oOperation->CS}
        {$oOperation->message}
    {/if}
    
{/foreach}