{$oAccount->number}
{$oAccount->type->name}
{$oAccount->client->name} {$oAccount->client->surname}
{$oAccount->value}
{$oAccount->avalaibleValue}
        
{foreach $aPersons as $oPerson}
    {$oPerson->ID}
    {$oPerson->client->name} {$oPerson->client->surname}
    {$oPerson->client->limit}
{/foreach}


{foreach $aOperations as $oOperation}
    {$oOperation->ID}
    {$oOperation->delegatedPerson->client->name} {$oPerson->delegatedPerson->client->surname}
    {$oOperation->employee->name} {$oOperation->employee->surname}
    {$oOperation->type->name}
    {$oOperation->date} (v db zm�n�n na timestamp, nezapome� aktualizovat db p�ipraven�m skriptem)
    {$oOperation->value}
    {if $oOperation->type < 3}
        V�b�ry/vklady (stejn� �ablona)
        
    {else}
        P�evody
        maj� nav�c tyto atributy
        {$oOperation->targetAccount}
        {$oOperation->bank}
        {$oOperation->VS}
        {$oOperation->SS}
        {$oOperation->CS}
        {$oOperation->message}
    {/if}
    
{/foreach}