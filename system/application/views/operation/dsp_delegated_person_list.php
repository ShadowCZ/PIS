<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu.php"}
    </div>
    <div class="col-md-9 column">
    {include file="./block/dsp_message.php"}
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Seznam delegovaný osob
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Pověřená osoba
                        </th>
                        <th>
                            Limit
                        </th>
                    </tr>
                </thead>
                    <tbody>
                        {foreach $aPersons as $oPerson}
                            <tr class='clickableRow' href="{site_url('coperation/showAccountDetail')}/{$oPerson->account}/{$oPerson->ID}">
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
<!--                         <div class="panel-footer">
                Panel footer
            </div> -->
        </div>
        
        
    </div>
</div>

