<?php
/**
 * Smarty modifier for translations
 * @author Andrej Farkas <a.farkas@pixvalley.com>
 * @param int $iPageNumber 
 * @param string $sPaginationKey
 * @return string
 */
function smarty_modifier_translate($iRecordId, $iTranslationType, $iLanguageId = null, $bShowEmptyMessage = true)
{    
    if ($iRecordId == 0 && $iTranslationType != Translations::TRANSLATION_CONTACT_CHANNEL)
    {
        return _('not_selected');
    }
        
    $oCI = get_instance();
    
    if (is_null($iLanguageId))
    {
        $iLanguageId = $oCI->muser->language->ID;
    }
        
    if ($bShowEmptyMessage)
    {
        $sTrnaslated = $oCI->translations->getTranslatedStringInLanguageWithDefaultMessage($iRecordId, $iTranslationType, $iLanguageId);            
    }
    else
    {
        $sTrnaslated = $oCI->translations->getTranslatedStringInLanguage($iRecordId, $iTranslationType, $iLanguageId);    
    }
    
    return $sTrnaslated;
}
