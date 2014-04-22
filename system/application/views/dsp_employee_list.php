Sviť měsíčku sviť, opaluj mou řit..

{* {$aEmployees} - pole objektů dle modelu MEmployee *}
{foreach $aEmployees as $oEmployee}
    {$oEmployee->name}
    {$oEmployee->surname}
    ...
{/foreach}