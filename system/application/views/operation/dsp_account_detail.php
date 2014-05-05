<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu.php"}
    </div>
    <div class="col-md-9 column">
        <ol class="breadcrumb">
            <li> <a href="{site_url('/coperation/showClientList')}">Klienti</a></li>
            <li> <a href="{site_url('/coperation/showAccountList')}/{$oAccount->client->ID}">Účty</a></li>
            <li> <a href="{site_url('/coperation/showDelegatedPersonList')}/{$oAccount->ID}">Delegované osoby</a></li>
            <li class="active">Detail</li>
        </ol>
        {include file="./block/dsp_message.php"}
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Účet {$oAccount->number} ({$oAccount->type->name})
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
                    <a href="{site_url('coperation/showTransfer')}/{$oAccount->ID}/{$oPerson->ID}">
                        <button  class="btn btn-success col-md-offset-1">Převod</button>
                    </a>
                </div>
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
        <div class="panel panel-success">
           <div class="panel-heading">
                <h3 class="panel-title">
                    Vklady / výběry
                </h3>
            </div>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Delegovaná osoba
                        </th>
                        <th>
                            Zaměstnanec
                        </th>
                        <th>
                            Typ
                        </th>
                        <th>
                            Datum
                        </th>
                        <th>
                            Částka
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $aOperations as $oOperation}
                        {if $oOperation->type->ID <= 2}
                        <tr>
                            <td>
                                {$oOperation->ID}
                            </td>
                            <td>
                                {$oOperation->delegatedPerson->client->name} {$oOperation->delegatedPerson->client->surname}
                            </td>
                            <td>
                                {$oOperation->employee->name} {$oOperation->employee->surname}
                            </td>
                            <td>
                                {$oOperation->type->name}
                            </td>
                            <td>
                                {$oOperation->date}
                            </td>
                            <td>
                                {$oOperation->value}
                            </td>
                        </tr>
                        {/if}
                    {/foreach}
                </tbody>
            </table>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Převody
                </h3>
            </div>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Delegovaná osoba
                        </th>
                        <th>
                            Zaměstnanec
                        </th>
                        <th>
                            Typ
                        </th>
                        <th>
                            Datum
                        </th>
                        <th>
                            Částka
                        </th>
                        <th>
                            Cílový účet
                        </th>
                        <th>
                            Banka
                        </th>
                        <th>
                            VS
                        </th>
                        <th>
                            SS
                        </th>
                        <th>
                            CS
                        </th>
                        <th>
                            Zpráva
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $aOperations as $oOperation}
                        {if $oOperation->type->ID > 2}
                        <tr>
                            <td>
                                {$oOperation->ID}
                            </td>
                            <td>
                                {$oOperation->delegatedPerson->client->name} {$oOperation->delegatedPerson->client->surname}
                            </td>
                            <td>
                                {$oOperation->employee->name} {$oOperation->employee->surname}
                            </td>
                            <td>
                                {$oOperation->type->name}
                            </td>
                            <td>
                                {$oOperation->date}
                            </td>
                            <td>
                                {$oOperation->value}
                            </td>
                            <td>
                                {$oOperation->targetAccount}
                            </td>
                            <td>
                                {$oOperation->bank}
                            </td>
                            <td>
                                {$oOperation->VS}
                            </td>
                            <td>
                                {$oOperation->SS}
                            </td>
                            <td>
                                {$oOperation->CS}
                            </td>
                            <td>
                                {$oOperation->message}
                            </td> 
                        </tr>
                        {/if}
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>