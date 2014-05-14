{foreach $aEmployees as $oEmployee}
    <tr  class='clickableRow' href="{site_url('cadmin/showEmployee')}/{$oEmployee->ID}">
        <td>
            {$oEmployee->ID}
        </td>
        <td>
            {$oEmployee->name}
        </td>
        <td>
            {$oEmployee->surname}
        </td>
        <td>
            {if $oEmployee->role}{$oEmployee->role->name}{/if}
        </td>
        <td>
            {$oEmployee->tel}
        </td>
        <td>
            {$oEmployee->email}
        </td>
        <td>
            {if $oEmployee->active}Ano{else}Ne{/if}
        </td>
        <td>
            {$oEmployee->lastIp}
        </td>
        <td class="dont-select">
            <a href="{site_url('cadmin/removeEmployee')}/{$oEmployee->ID}">
                <button type="button" class="btn btn-danger btn-md">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
            </a>
        </td>
    </tr>
{/foreach}
 