 <ul class="nav nav-stacked nav-pills">
    {foreach $aMenu as $index => $aMenuSet}
        <li {if $index == $iActiveMenu}class="active"{/if}>
            {anchor uri=$aMenuSet['href'] label=$aMenuSet['label']}
        </li>
    {/foreach}
    
    {*
    <li class="active">
        <a href="{site_url('cadmin/showEmployeeList')}">Zaměstnanci</a>
    </li>
    <li>
        {anchor uri="/cadvice/showClientList" label="Klienti"}
    </li>
    <li>
        {anchor uri="/cadvice/showAccountList" label="Účty"}
    </li>
    <li>
        {anchor uri="/coperation/showAccountList" label="Podat příkaz"}
    </li>
    <li>
        {anchor uri="/coperation/showClientList" label="Netuším co to je"}
    </li>
    <li>
        {anchor uri="/ctransaction/showTransferList" label="Potvrzení převodů"}
    </li>
    <li>
        {anchor uri="/ctransaction/showOperationList" label="Přehled vkladů / výběrů"}
    </li>
    <li>
        <a href="#">X Účty</a>
    </li>
    <li>
        <a href="#">X Klienti</a>
    </li>
    <li>
        <a href="#">X Transakce</a>
    </li>
    <li>
        <a href="#">X Messages</a>
    </li>
    <li>
        <a href="#">X Messages</a>
    </li>
    *}
    
</ul>