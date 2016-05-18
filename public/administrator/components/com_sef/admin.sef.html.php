<?php
/**
 * SEF module for Joomla!
 * Originally written for Mambo as 404SEF by W. H. Welch.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007
 * @package     sh404SEF
 * @version     $Id: admin.sef.html.php 24 2007-09-19 18:35:29Z silianacom-svn $
 * {shSourceVersionTag: Version x - 2007-09-20} 
 */
 
// Security check to ensure this file is being included by a parent file.
if (!defined('_VALID_MOS')) die('Direct Access to this location is not allowed.');

class HTML_sef

{

	function shTextParamHTML($x, $pTitle, $pToolTip, $pName, $pValue, $pSize, $pLength) {
	
		$output  = '<tr'.(($x % 2) ? '':' class="row1"' )."\n";
		$output .= '  <td width="200">'.$pTitle.'</td>'."\n"
	    	      .'  <td width="150"><input type="text" name="'.$pName.'" value="'.$pValue
	        	  .'" size="'.$pSize.'" maxlength="'.pLength.'"></td>'."\n"
	          	  .'  ;<td>'.mosToolTip($pToolTip, $pTitle)."</td>\n"
	    		  .'</tr>'."\n";
		echo $output;    	
	}
	
	function shYesNoParamHTML( $x, $pTitle, $pToolTip, $pName) {
		$output  = '<tr'.(($x % 2) ? '':' class="row1"' )."\n";
		$output .= '<td width="200">'.$pTitle.'?</td>'."\n";
	    $output .= '<td width="150">'.$pName.'</td>'."\n";
	    $output .= '<td>'. mosToolTip($pToolTip, $pTitle).'</td>'."\n";
	    $output .= "</tr>\n";
	    echo $output;
	}       
	        
	function configuration(&$lists, $txt404)
	
	{
	   global $sefConfig, $sef_config_file;
	   
	   $tabs = new mosTabs(0);
	   
	?>
		<table class="adminheading">
		<tr><th>
		<?php
		echo _COM_SEF_TITLE_CONFIG.((file_exists( $sef_config_file )) ? ((is_writable( $sef_config_file )) ? _COM_SEF_WRITEABLE : _COM_SEF_UNWRITEABLE ) : _COM_SEF_USING_DEFAULT)
		?>
		<br/><font class="small" align="left"><a href="index2.php?option=com_sef"><?php echo _COM_SEF_BACK?></a></font>
		</th></tr>
		</table>
		<?php if (!$GLOBALS['mosConfig_sef']) {
	               	echo _COM_SEF_DISABLED;
	       	}
	       	$x=0;
	       	?>
	        <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	        <script language="Javascript" src="<?php echo $GLOBALS['mosConfig_live_site']; ?>/includes/js/overlib_mini.js"></script>
	        <script language="Javascript">
				    function submitbutton(pressbutton) {
				      if (pressbutton == 'save') {
	                var eraseCache = confirm("<?php echo _COM_SEF_CONFIRM_ERASE_CACHE; ?>");
	                if (eraseCache) document.getElementById("eraseCache").value = "1";
	            }
							<?php getEditorContents( 'editor1', 'introtext' ) ; ?>
							submitform( pressbutton );
					}
					//-->
					</script>
	        <form action="index2.php?option=com_sef&task=saveconfig" method="post" name="adminForm" id="adminForm">
	<?php         
	  $tabs->startPane("sh404SEFConf");
  	$tabs->startTab( _COM_SEF_SH_CONF_TAB_MAIN,"basics");    
	?>        
        <table class="adminform">
	        <tr>
	            <th colspan="4"><?php echo _COM_SEF_TITLE_BASIC; ?></th>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_ENABLED;?>?</td>
	            <td width="150"><?php echo $lists['enabled'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_ENABLED,_COM_SEF_ENABLED);?></td>
	            <td rowspan="18" valign="top" align="right"><b>
	             <?php echo _COM_SEF_DEF_404_PAGE;?></b><br/><br/>
			<?php
			// parameters : areaname, content, hidden field, width, height, cols, rows
			editorArea( 'editor1',  $txt404, 'introtext','450','150','50','11' );
			?>
	            </td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_REPLACE_CHAR;?></td>
	            <td width="150"><input type="text" name="replacement" value="<?php echo $sefConfig->replacement;?>" size="1" maxlength="1"></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_REPLACE_CHAR,_COM_SEF_REPLACE_CHAR);?></td>
	        </tr>
	        <?php if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) { ?>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_PAGEREP_CHAR;?></td>
	            <td width="150"><input type="text" name="pagerep" value="<?php echo $sefConfig->pagerep;?>" size="1" maxlength="1"></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_PAGEREP_CHAR,_COM_SEF_PAGEREP_CHAR);?></td>
	        </tr>
	        <?php } ?>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_STRIP_CHAR;?></td>
	            <td width="150"><input type="text" name="stripthese" value="<?php echo $sefConfig->stripthese;?>" size="60" maxlength="255"></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_STRIP_CHAR,_COM_SEF_STRIP_CHAR);?></td>
	        </tr>
	        <!-- shumisha 2007-04-01 new param for characters replacement table  -->
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_REPLACEMENTS;?></td>
	            <td width="150"><textarea name="shReplacements" cols="60" rows="5"><?php echo $sefConfig->shReplacements;?></textarea></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_REPLACEMENTS,_COM_SEF_SH_REPLACEMENTS);?></td>
	        </tr>
          <!-- shumisha 2007-04-01 end of new param for characters replacement table  -->
          <?php if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) { ?>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_FRIENDTRIM_CHAR;?></td>
	            <td width="150"><input type="text" name="friendlytrim" value="<?php echo $sefConfig->friendlytrim;?>" size="60" maxlength="255"></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_FRIENDTRIM_CHAR,_COM_SEF_FRIENDTRIM_CHAR);?></td>
	        </tr>
	      <?php } ?>  
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_USE_ALIAS;?>?</td>
	            <td width="150"><?php echo $lists['usealias'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_USE_ALIAS,_COM_SEF_USE_ALIAS);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SUFFIX;?></td>
	            <td width="150"><input type="text" name="suffix" value="<?php echo $sefConfig->suffix; ?>" size="6" maxlength="6"></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SUFFIX,_COM_SEF_SUFFIX);?></td>
	        </tr>
	        <?php if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) { ?>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_ADDFILE;?></td>
	            <td width="150"><input type="text" name="addFile" value="<?php echo $sefConfig->addFile; ?>" size="60" maxlength="60"></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_ADDFILE,_COM_SEF_ADDFILE);?></td>
	        </tr>
	        
	        <?php $x++; echo HTML_sef::shYesNoParamHTML( $x, _COM_SEF_LOWER, _COM_SEF_TT_LOWER, $lists['lowercase']);?>
	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_404PAGE;?></td>
	            <td width="150"><?php echo $lists['page404'];?></td>
	            <td>
	            <?php echo mosToolTip(_COM_SEF_TT_404PAGE,_COM_SEF_404PAGE);?>
	            </td>
	        </tr>
	        <?php } ?>
	        <!-- shumisha 2007-04-01 new params for Numerical Id insert  -->
	        <th colspan="3"><?php echo _COM_SEF_SH_INSERT_NUMERICAL_ID_TITLE;?></th>
          	<?php $x++; echo HTML_sef::shYesNoParamHTML( $x, 
	        		_COM_SEF_SH_INSERT_NUMERICAL_ID_TITLE, _COM_SEF_TT_SH_INSERT_NUMERICAL_ID, 
	        		$lists['shInsertNumericalId']);?>	
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_NUMERICAL_ID_CAT_LIST;?>?</td>
	            <td width="150"><?php echo $lists['shInsertNumericalIdCatList'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_NUMERICAL_ID_CAT_LIST,
                _COM_SEF_SH_INSERT_NUMERICAL_ID_CAT_LIST);?></td>
	        </tr>
	        <!-- shumisha 2007-04-01 end of new params for Numerical Id insert  -->
	</table>      
	<?php        
	$tabs->endTab();
	$tabs->startTab(_COM_SEF_SH_CONF_TAB_PLUGINS,"plugins");
  ?>  
  <table class="adminform">
   
          <!-- shumisha 2007-06-30 new params for regular content  -->	  
          <th colspan="3"><?php echo _COM_SEF_SH_CONTENT_TITLE;?></th>
          	<?php $x++; echo HTML_sef::shYesNoParamHTML( $x, 
	        		_COM_SEF_SHOW_SECT, _COM_SEF_TT_SHOW_SECT, 
	        		$lists['showsection']); 
				  $x++; echo HTML_sef::shYesNoParamHTML( $x, 
	        		_COM_SEF_SHOW_CAT, _COM_SEF_TT_SHOW_CAT, 
	        		$lists['showcat']);?> 
	      <?php
	      if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) {
	        
	        $x++; echo HTML_sef::shYesNoParamHTML( $x, 
	        		_COM_SEF_SH_INSERT_CONTENT_TABLE_NAME, _COM_SEF_TT_SH_INSERT_CONTENT_TABLE_NAME, 
	        		$lists['shInsertContentTableName']);?>

          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_CONTENT_TABLE_NAME;?></td>
	            <td width="150"><input type="text" name="shContentTableName" value="<?php echo $sefConfig->shContentTableName;?>" size="30" maxlength="30"></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_CONTENT_TABLE_NAME,
                                         _COM_SEF_SH_CONTENT_TABLE_NAME);?></td>
	      </tr>
	      <?php $x++; echo HTML_sef::shYesNoParamHTML( $x, 
	        		_COM_SEF_SH_INSERT_CONTENT_BLOG_NAME, _COM_SEF_TT_SH_INSERT_CONTENT_BLOG_NAME, 
	        		$lists['shInsertContentBlogName']);?>
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_CONTENT_BLOG_NAME;?></td>
	            <td width="150"><input type="text" name="shContentBlogName" value="<?php echo $sefConfig->shContentBlogName;?>" size="30" maxlength="30"></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_CONTENT_BLOG_NAME,
                                         _COM_SEF_SH_CONTENT_BLOG_NAME);?></td>
	      </tr>
	      <?php $x++; echo HTML_sef::shYesNoParamHTML( $x, 
	        		_COM_SEF_SH_INSERT_CONTENT_MULTIPAGES_TITLE, _COM_SEF_TT_SH_INSERT_CONTENT_MULTIPAGES_TITLE, 
	        		$lists['shMultipagesTitle']);?>  
	      <?php
		  } 
	      if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) {
	      ?>
	        
          <!-- shumisha 2007-04-01 new params for Virtuemart  -->	  
          <th colspan="3"><?php echo _COM_SEF_SH_VM_TITLE;?></th>   
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_VM_INSERT_SHOP_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shVmInsertShopName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_VM_INSERT_SHOP_NAME._COM_SEF_TT_SH_NAME_BY_COMP,
                _COM_SEF_SH_VM_INSERT_SHOP_NAME);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_PRODUCT_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shVmInsertProductName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_PRODUCT_NAME,
                _COM_SEF_SH_INSERT_PRODUCT_NAME);?></td>
	        </tr>
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_PRODUCT_ID;?>?</td>
	            <td width="150"><?php echo $lists['shInsertProductId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_PRODUCT_ID,
                _COM_SEF_SH_INSERT_PRODUCT_ID);?></td>
	        </tr>
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_VM_USE_PRODUCT_SKU_124S;?>?</td>
	            <td width="150"><?php echo $lists['shVmUseProductSKU'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_VM_USE_PRODUCT_SKU_124S,
                _COM_SEF_SH_VM_USE_PRODUCT_SKU_124S);?></td>
	        </tr>
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_VM_INSERT_MANUFACTURER_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shVmInsertManufacturerName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_VM_INSERT_MANUFACTURER_NAME,
                _COM_SEF_SH_VM_INSERT_MANUFACTURER_NAME);?></td>
	        </tr>
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_VM_INSERT_MANUFACTURER_ID;?>?</td>
	            <td width="150"><?php echo $lists['shInsertManufacturerId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_VM_INSERT_MANUFACTURER_ID,
                _COM_SEF_SH_VM_INSERT_MANUFACTURER_ID);?></td>
	        </tr>            
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_VM_INSERT_CATEGORIES;?></td>
	            <td width="150"><?php echo $lists['shVMInsertCategories'];?></td>
	            <td>
	            <?php echo mosToolTip(_COM_SEF_TT_SH_VM_INSERT_CATEGORIES,_COM_SEF_SH_VM_INSERT_CATEGORIES);?>
	            </td>
	        </tr>   
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_VM_INSERT_CATEGORY_ID;?>?</td>
	            <td width="150"><?php echo $lists['shInsertCategoryId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_VM_INSERT_CATEGORY_ID,
                _COM_SEF_SH_VM_INSERT_CATEGORY_ID);?></td>
	        </tr> 
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_VM_ADDITIONAL_TEXT;?>?</td>
	            <td width="150"><?php echo $lists['shVmAdditionalText'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_VM_ADDITIONAL_TEXT,
                _COM_SEF_SH_VM_ADDITIONAL_TEXT);?></td>
	        </tr> 
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_VM_INSERT_FLYPAGE;?>?</td>
	            <td width="150"><?php echo $lists['shVmInsertFlypage'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_VM_INSERT_FLYPAGE,
                _COM_SEF_SH_VM_INSERT_FLYPAGE);?></td>
	        </tr> 
          <!-- shumisha 2007-04-01 end of new params for Virtuemart  -->
          
          <!-- shumisha 2007-04-25 new params for Community Builder  -->	  
          <th colspan="3"><?php echo _COM_SEF_SH_CB_TITLE;?></th>   
          
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>         
	            <td width="200"><?php echo _COM_SEF_SH_CB_INSERT_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shInsertCBName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_CB_INSERT_NAME._COM_SEF_TT_SH_NAME_BY_COMP,
                _COM_SEF_SH_CB_INSERT_NAME);?></td>
	        </tr>
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_CB_INSERT_USER_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shCBInsertUserName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_CB_INSERT_USER_NAME,
                _COM_SEF_SH_CB_INSERT_USER_NAME);?></td>
	        </tr>
	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_CB_INSERT_USER_ID;?>?</td>
	            <td width="150"><?php echo $lists['shCBInsertUserId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_CB_INSERT_USER_ID,
                _COM_SEF_SH_CB_INSERT_USER_ID);?></td>
	        </tr>
	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_CB_USE_USER_PSEUDO;?>?</td>
	            <td width="150"><?php echo $lists['shCBUseUserPseudo'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_CB_USE_USER_PSEUDO,
                _COM_SEF_SH_CB_USE_USER_PSEUDO);?></td>
	        </tr>
	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_CB_SHORT_USER_URL;?>?</td>
	            <td width="150"><?php echo $lists['shCBShortUserURL'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_CB_SHORT_USER_URL,
                _COM_SEF_SH_CB_SHORT_USER_URL);?></td>
	        </tr>
	        <!-- shumisha 2007-04-25 new params for Community Builder  -->
    
          <!-- shumisha 2007-04-25 new params for Fireboard  -->	  
          <th colspan="3"><?php echo _COM_SEF_SH_FB_TITLE;?></th>   
          
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>         
	            <td width="200"><?php echo _COM_SEF_SH_FB_INSERT_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shInsertFireboardName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_FB_INSERT_NAME._COM_SEF_TT_SH_NAME_BY_COMP,
                _COM_SEF_SH_FB_INSERT_NAME);?></td>
	        </tr> 
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_FB_INSERT_CATEGORY_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shFbInsertCategoryName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_FB_INSERT_CATEGORY_NAME,
                _COM_SEF_SH_FB_INSERT_CATEGORY_NAME);?></td>
	        </tr>
	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_FB_INSERT_CATEGORY_ID;?>?</td>
	            <td width="150"><?php echo $lists['shFbInsertCategoryId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_FB_INSERT_CATEGORY_ID,
                _COM_SEF_SH_FB_INSERT_CATEGORY_ID);?></td>
	        </tr>
	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_FB_INSERT_MESSAGE_SUBJECT;?>?</td>
	            <td width="150"><?php echo $lists['shFbInsertMessageSubject'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_FB_INSERT_MESSAGE_SUBJECT,
                _COM_SEF_SH_FB_INSERT_MESSAGE_SUBJECT);?></td>
	        </tr>
	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_FB_INSERT_MESSAGE_ID;?>?</td>
	            <td width="150"><?php echo $lists['shFbInsertMessageId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_FB_INSERT_MESSAGE_ID,
                _COM_SEF_SH_FB_INSERT_MESSAGE_ID);?></td>
	        </tr>
	        <!-- shumisha 2007-04-25 new params for Fireboardr  -->
          
           <!-- shumisha 2007-06-21 new params for Docman  -->	  
          <th colspan="3"><?php echo _COM_SEF_SH_DOCMAN_TITLE;?></th>   
          
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>         
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shInsertDocmanName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_NAME._COM_SEF_TT_SH_NAME_BY_COMP,
                _COM_SEF_SH_DOCMAN_INSERT_NAME);?></td>
	        </tr>
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_DOC_ID;?>?</td>
	            <td width="150"><?php echo $lists['shDocmanInsertDocId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_DOC_ID,
                _COM_SEF_SH_DOCMAN_INSERT_DOC_ID);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_DOC_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shDocmanInsertDocName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_DOC_NAME,
                _COM_SEF_SH_DOCMAN_INSERT_DOC_NAME);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_CAT_ID;?>?</td>
	            <td width="150"><?php echo $lists['shDMInsertCategoryId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_CAT_ID,
                _COM_SEF_SH_DOCMAN_INSERT_CAT_ID);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_CATEGORIES;?></td>
	            <td width="150"><?php echo $lists['shDMInsertCategories'];?></td>
	            <td>
	            <?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_CATEGORIES,_COM_SEF_SH_DOCMAN_INSERT_CATEGORIES);?>
	            </td>
	        </tr>
	        
          <!-- shumisha 2007-06-21 new params for Docman  -->
          
           <!-- shumisha 2007-08-12 new params for Remository  -->	  
          <th colspan="3"><?php echo _COM_SEF_SH_REMO_TITLE;?></th>   
          
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>         
	            <td width="200"><?php echo _COM_SEF_SH_REMO_INSERT_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shInsertRemoName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_REMO_INSERT_NAME._COM_SEF_TT_SH_NAME_BY_COMP,
                _COM_SEF_SH_REMO_INSERT_NAME);?></td>
	        </tr> 
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_DOC_ID;?>?</td>
	            <td width="150"><?php echo $lists['shRemoInsertDocId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_DOC_ID,
                _COM_SEF_SH_DOCMAN_INSERT_DOC_ID);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_DOC_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shRemoInsertDocName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_DOC_NAME,
                _COM_SEF_SH_DOCMAN_INSERT_DOC_NAME);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_CAT_ID;?>?</td>
	            <td width="150"><?php echo $lists['shRemoInsertCategoryId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_CAT_ID,
                _COM_SEF_SH_DOCMAN_INSERT_CAT_ID);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_CATEGORIES;?></td>
	            <td width="150"><?php echo $lists['shRemoInsertCategories'];?></td>
	            <td>
	            <?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_CATEGORIES,_COM_SEF_SH_DOCMAN_INSERT_CATEGORIES);?>
	            </td>
	        </tr>
	        
          <!-- shumisha 2007-08-12 new params for Remository  -->
          
	        <!-- shumisha 2007-04-01 new params for Letterman  -->
	        <th colspan="3"><?php echo _COM_SEF_SH_LETTERMAN_TITLE;?></th>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_LETTERMAN_DEFAULT_ITEMID;?></td>
	            <td width="150"><input type="text" name="shLMDefaultItemid" value="<?php echo $sefConfig->shLMDefaultItemid; ?>" size="10" maxlength="10"></td>
             <td><?php echo mosToolTip( _COM_SEF_TT_SH_LETTERMAN_DEFAULT_ITEMID,
                                        _COM_SEF_SH_LETTERMAN_DEFAULT_ITEMID);?></td>
	        </tr>
	        <!-- shumisha 2007-04-01 end of new params for Letterman  -->
	        
	        <!-- shumisha 2007-06-21 new params for MyBlog  -->	  
          <th colspan="3"><?php echo _COM_SEF_SH_MYBLOG_TITLE;?></th>   
          
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>         
	            <td width="200"><?php echo _COM_SEF_SH_MYBLOG_INSERT_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shInsertMyBlogName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_MYBLOG_INSERT_NAME._COM_SEF_TT_SH_NAME_BY_COMP,
                _COM_SEF_SH_MYBLOG_INSERT_NAME);?></td>
	        </tr>
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_MYBLOG_INSERT_POST_ID;?>?</td>
	            <td width="150"><?php echo $lists['shMyBlogInsertPostId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_MYBLOG_INSERT_POST_ID,
                _COM_SEF_SH_MYBLOG_INSERT_POST_ID);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_MYBLOG_INSERT_TAG_ID;?>?</td>
	            <td width="150"><?php echo $lists['shMyBlogInsertTagId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_MYBLOG_INSERT_TAG_ID,
                _COM_SEF_SH_MYBLOG_INSERT_TAG_ID);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_MYBLOG_INSERT_BLOGGER_ID;?>?</td>
	            <td width="150"><?php echo $lists['shMyBlogInsertBloggerId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_MYBLOG_INSERT_BLOGGER_ID,
                _COM_SEF_SH_MYBLOG_INSERT_BLOGGER_ID);?></td>
	        </tr>
          <!-- shumisha 2007-06-21 new params for Myblog  -->
	         
           <!-- shumisha 2007-08-06 new params for Mosets Tree  -->	  
          <th colspan="3"><?php echo _COM_SEF_SH_MTREE_TITLE;?></th>   
          
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>         
	            <td width="200"><?php echo _COM_SEF_SH_MTREE_INSERT_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shInsertMTreeName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_MTREE_INSERT_NAME._COM_SEF_TT_SH_NAME_BY_COMP,
                _COM_SEF_SH_MTREE_INSERT_NAME);?></td>
	        </tr>
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_MTREE_INSERT_LISTING_ID;?>?</td>
	            <td width="150"><?php echo $lists['shMTreeInsertListingId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_MTREE_INSERT_LISTING_ID,
                _COM_SEF_SH_MTREE_INSERT_LISTING_ID);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_MTREE_PREPEND_LISTING_ID;?>?</td>
	            <td width="150"><?php echo $lists['shMTreePrependListingId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_MTREE_PREPEND_LISTING_ID,
                _COM_SEF_SH_MTREE_PREPEND_LISTING_ID);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_MTREE_INSERT_LISTING_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shMTreeInsertListingName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_MTREE_INSERT_LISTING_NAME,
                _COM_SEF_SH_MTREE_INSERT_LISTING_NAME);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_CAT_ID;?>?</td>
	            <td width="150"><?php echo $lists['shMTreeInsertCategoryId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_CAT_ID,
                _COM_SEF_SH_DOCMAN_INSERT_CAT_ID);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_DOCMAN_INSERT_CATEGORIES;?></td>
	            <td width="150"><?php echo $lists['shMTreeInsertCategories'];?></td>
	            <td>
	            <?php echo mosToolTip(_COM_SEF_TT_SH_DOCMAN_INSERT_CATEGORIES,_COM_SEF_SH_DOCMAN_INSERT_CATEGORIES);?>
	            </td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_CB_INSERT_USER_ID;?>?</td>
	            <td width="150"><?php echo $lists['shMTreeInsertUserId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_CB_INSERT_USER_ID,
                _COM_SEF_SH_CB_INSERT_USER_ID);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_CB_INSERT_USER_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shMTreeInsertUserName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_CB_INSERT_USER_NAME,
                _COM_SEF_SH_CB_INSERT_USER_NAME);?></td>
	        </tr>
	        
          <!-- shumisha 2007-06-21 new params for Docman  -->         
           
          <!-- shumisha 2007-04-25 new params for iJoomla magazine  -->	  
          <th colspan="3"><?php echo _COM_SEF_SH_IJOOMLA_MAG_TITLE;?></th>   
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ACTIVATE_IJOOMLA_MAG;?>?</td>
	            <td width="150"><?php echo $lists['shActivateIJoomlaMagInContent'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_ACTIVATE_IJOOMLA_MAG,
                _COM_SEF_SH_ACTIVATE_IJOOMLA_MAG);?></td>
	        </tr>
          
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>         
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_IJOOMLA_MAG_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shInsertIJoomlaMagName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_IJOOMLA_MAG_NAME._COM_SEF_TT_SH_NAME_BY_COMP,
                _COM_SEF_SH_INSERT_IJOOMLA_MAG_NAME);?></td>
	        </tr>
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_IJOOMLA_MAG_MAGAZINE_ID;?>?</td>
	            <td width="150"><?php echo $lists['shInsertIJoomlaMagMagazineId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_IJOOMLA_MAG_MAGAZINE_ID,
                _COM_SEF_SH_INSERT_IJOOMLA_MAG_MAGAZINE_ID);?></td>
	        </tr>
	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_IJOOMLA_MAG_ISSUE_ID;?>?</td>
	            <td width="150"><?php echo $lists['shInsertIJoomlaMagIssueId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_IJOOMLA_MAG_ISSUE_ID,
                _COM_SEF_SH_INSERT_IJOOMLA_MAG_ISSUE_ID);?></td>
	        </tr>
	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_IJOOMLA_MAG_ARTICLE_ID;?>?</td>
	            <td width="150"><?php echo $lists['shInsertIJoomlaMagArticleId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_IJOOMLA_MAG_ARTICLE_ID,
                _COM_SEF_SH_INSERT_IJOOMLA_MAG_ARTICLE_ID);?></td>
	        </tr>
	        <!-- shumisha 2007-04-25 new params for iJoomla magazine  -->   
          <!-- shumisha 2007-08-07 new params for iJoomla NewsPortal  -->	  
          <th colspan="3"><?php echo _COM_SEF_SH_IJOOMLA_NEWSP_TITLE;?></th>   
         
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>         
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_IJOOMLA_NEWSP_NAME;?>?</td>
	            <td width="150"><?php echo $lists['shInsertNewsPName'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_IJOOMLA_NEWSP_NAME._COM_SEF_TT_SH_NAME_BY_COMP,
                _COM_SEF_SH_INSERT_IJOOMLA_NEWSP_NAME);?></td>
	        </tr> 
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>     
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_IJOOMLA_NEWSP_CAT_ID;?>?</td>
	            <td width="150"><?php echo $lists['shNewsPInsertCatId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_IJOOMLA_NEWSP_CAT_ID,
                _COM_SEF_SH_INSERT_IJOOMLA_NEWSP_CAT_ID);?></td>
	        </tr>
	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_IJOOMLA_NEWSP_SECTION_ID;?>?</td>
	            <td width="150"><?php echo $lists['shNewsPInsertSecId'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_IJOOMLA_NEWSP_SECTION_ID,
                _COM_SEF_SH_INSERT_IJOOMLA_NEWSP_SECTION_ID);?></td>
	        </tr>
	        <!-- shumisha 2007-08-07 new params for iJoomla NewsPortal  --> 
      <?php } ?>    
</table>      
	<?php        
	$tabs->endTab();
	$tabs->startTab(_COM_SEF_SH_CONF_TAB_LANGUAGES,'Languages');
	?>

<table
	class="adminform">

	<!-- shumisha 27/09/2007 new params for languages management  -->
	<th colspan="3"><?php echo _COM_SEF_SH_TRANSLATION_TITLE;?></th>
	<tr <?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
		<td width="200"><?php echo _COM_SEF_SH_TRANSLATE_URL;?>?</td>
		<td width="150"><?php echo $lists['shTranslateURL'];?></td>
		<td><?php echo mosToolTip(_COM_SEF_TT_SH_TRANSLATE_URL_GEN,_COM_SEF_SH_TRANSLATE_URL);?></td>
	</tr>
	<tr <?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
		<td width="200"><?php echo _COM_SEF_SH_INSERT_LANGUAGE_CODE;?>?</td>
		<td width="150"><?php echo $lists['shInsertLanguageCode'];?></td>
		<td><?php echo mosToolTip( _COM_SEF_TT_SH_INSERT_LANGUAGE_CODE_GEN,
		_COM_SEF_SH_INSERT_LANGUAGE_CODE);?></td>
	</tr>
	<?php
	if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) {
		foreach($lists['activeLanguages'] as $currentLang) {
	?>	
	<th colspan="3"><?php echo ucfirst($currentLang);?></th>
	<tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_PAGETEXT;?></td>
	            <td width="150"><input type="text" name="<?php echo 'languages_'.$currentLang.'_pageText'; ?>" value="<?php echo $sefConfig->pageTexts[$currentLang]; ?>" size="10" maxlength="20"></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_PAGETEXT,_COM_SEF_PAGETEXT);?></td>
	        </tr>
	<tr <?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
		<td width="200"><?php echo _COM_SEF_SH_TRANSLATE_URL;?>?</td>
		<td width="150"><?php echo $lists['languages_'.$currentLang.'_translateURL'];?></td>
		<td><?php echo mosToolTip(_COM_SEF_TT_SH_TRANSLATE_URL_PER_LANG,_COM_SEF_SH_TRANSLATE_URL);?></td>
	</tr>
	<tr <?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
		<td width="200"><?php echo _COM_SEF_SH_INSERT_LANGUAGE_CODE;?>?</td>
		<td width="150"><?php echo $lists['languages_'.$currentLang.'_insertCode'];?></td>
		<td><?php echo mosToolTip( _COM_SEF_TT_SH_INSERT_LANGUAGE_CODE_PER_LANG,
		_COM_SEF_SH_INSERT_LANGUAGE_CODE);?></td>
	</tr>
	
	<?php
		}  // end of language loop 
	}  // end of standard/advanced UI	
	?>
	<!-- shumisha 27/09/2007 new params for languages management  -->

</table>

<?php	
	$tabs->endTab();
	if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) {
	$tabs->startTab(_COM_SEF_SH_CONF_TAB_ADVANCED,"Advanced");
	?>  
  <table class="adminform">        
	        
	        <!-- shumisha 2007-04-01 new params for cache  -->
	        <tr><th colspan="4"><?php echo _COM_SEF_SH_CACHE_TITLE;?></th></tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_USE_URL_CACHE;?></td>
	            <td width="150"><?php echo $lists['shUseURLCache'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_USE_URL_CACHE,_COM_SEF_SH_USE_URL_CACHE);?></td>
	            <td></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_MAX_URL_IN_CACHE;?></td>
	            <td width="150"><input type="text" name="shMaxURLInCache" value="<?php echo $sefConfig->shMaxURLInCache; ?>" size="10" maxlength="10"></td>
             <td><?php echo mosToolTip(_COM_SEF_TT_SH_MAX_URL_IN_CACHE,_COM_SEF_SH_MAX_URL_IN_CACHE);?></td>
             <td></td>
	        </tr>
	        <!-- shumisha 2007-04-01 end of new params for cache  -->
	        
	        <tr>
	        <th colspan="8"><?php echo _COM_SEF_TITLE_ADV;?></th>
	        </tr>
	        
	        <!-- shumisha 2007-06-23 new param to select rewrite mode  -->
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_SELECT_REWRITE_MODE;?>?</td>
	            <td width="150"><?php echo $lists['shRewriteMode'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_SELECT_REWRITE_MODE,
                _COM_SEF_SH_SELECT_REWRITE_MODE);?></td>
              <td></td>  
	        </tr>	
	        <!-- shumisha 2007-06-23 new param to select rewrite mode  -->
	        <!-- shumisha 2007-04-13 new params for automatic 301 redirect of non-sef URL  -->
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_REDIRECT_NON_SEF_TO_SEF;?>?</td>
	            <td width="150"><?php echo $lists['shRedirectNonSefToSef'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_REDIRECT_NON_SEF_TO_SEF,
                _COM_SEF_SH_REDIRECT_NON_SEF_TO_SEF);?></td>
              <td></td>  
	        </tr>	
	        <!-- shumisha 2007-05-4 new params for automatic 301 redirect of joomla-sef URL  -->
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_REDIRECT_JOOMLA_SEF_TO_SEF;?>?</td>
	            <td width="150"><?php echo $lists['shRedirectJoomlaSefToSef'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_REDIRECT_JOOMLA_SEF_TO_SEF,
                _COM_SEF_SH_REDIRECT_JOOMLA_SEF_TO_SEF);?></td>
              <td></td>  
	        </tr>
	        <!-- shumisha 2007-05-4 new params for automatic 301 redirect of joomla-sef URL  -->
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_REDIRECT_WWW;?>?</td>
	            <td width="150"><?php echo $lists['shAutoRedirectWww'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_REDIRECT_WWW,
                _COM_SEF_SH_REDIRECT_WWW);?></td>
              <td></td>  
	        </tr>
	        <!-- V 1.2.4.s new param to enable/disable duplicated URL logging to DB  -->
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_RECORD_DUPLICATES;?>?</td>
	            <td width="150"><?php echo $lists['shRecordDuplicates'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_RECORD_DUPLICATES,
                _COM_SEF_SH_RECORD_DUPLICATES);?></td>
              <td></td>  
	        </tr>	
	        <!-- V 1.2.4.s new param to enable/disable duplicated URL logging to DB  -->
	        <!-- V 1.2.4.k new param to enable/disable 404 errors logging to DB  -->
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_LOG_404_ERRORS;?>?</td>
	            <td width="150"><?php echo $lists['shLog404Errors'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_LOG_404_ERRORS,
                _COM_SEF_SH_LOG_404_ERRORS);?></td>
              <td></td>  
	        </tr>	
	        <!-- shumisha 2007-04-13 end of new params for enable/disable 404 errors logging to DB  -->
          <!-- shumisha 2007-04-13 new params for secure live site URL  -->
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_LIVE_SECURE_SITE;?></td>
	            <td width="150"><input type="text" name="shConfig_live_secure_site" value="<?php echo $sefConfig->shConfig_live_secure_site;?>" size="30" maxlength="60"></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_LIVE_SECURE_SITE,
                                         _COM_SEF_SH_LIVE_SECURE_SITE);?></td>
              <td></td>                           
	        </tr> 
	        <!-- shumisha 2007-04-13 end of new params for secure live site  -->
          <!-- shumisha 2007-04-13 new params for HTTPS force non sef  -->
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_FORCE_NON_SEF_HTTPS;?>?</td>
	            <td width="150"><?php echo $lists['shForceNonSefIfHttps'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_FORCE_NON_SEF_HTTPS,
                _COM_SEF_SH_FORCE_NON_SEF_HTTPS);?></td>
              <td></td>  
	        </tr>
          <!-- shumisha 2007-04-13 end of new params HTTPS force non sef  -->
          <!-- shumisha 2007-05-28 new params for URL encoding  -->
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ENCODE_URL;?>?</td>
	            <td width="150"><?php echo $lists['shEncodeUrl'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_ENCODE_URL,
                _COM_SEF_SH_ENCODE_URL);?></td><td></td>
	        </tr>
	        <!-- shumisha 2007-04-13 end of new params for  URL encoding -->
	        <!-- shumisha 2007-08-03 new params for forced homepage URL  -->
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_FORCED_HOMEPAGE;?></td>
	            <td width="150"><input type="text" name="shForcedHomePage" value="<?php echo $sefConfig->shForcedHomePage;?>" size="30" maxlength="60"></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_FORCED_HOMEPAGE,
                                         _COM_SEF_SH_FORCED_HOMEPAGE);?></td>
              <td></td>                           
	        </tr> 
          <!-- shumisha 2007-04-01 new params for Itemid handling and URL construction  -->
          <th colspan="4"><?php echo _COM_SEF_SH_ITEMID_TITLE;?></th>  
           <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_GUESS_HOMEPAGE_ITEMID;?>?</td>
	            <td width="150"><?php echo $lists['guessItemidOnHomepage'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_GUESS_HOMEPAGE_ITEMID,
                _COM_SEF_SH_GUESS_HOMEPAGE_ITEMID);?></td><td></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_GLOBAL_ITEMID_IF_NONE;?>?</td>
	            <td width="150"><?php echo $lists['shInsertGlobalItemidIfNone'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_GLOBAL_ITEMID_IF_NONE,
                _COM_SEF_SH_INSERT_GLOBAL_ITEMID_IF_NONE);?></td><td></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_INSERT_TITLE_IF_NO_ITEMID;?>?</td>
	            <td width="150"><?php echo $lists['shInsertTitleIfNoItemid'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_INSERT_TITLE_IF_NO_ITEMID,
                _COM_SEF_SH_INSERT_TITLE_IF_NO_ITEMID);?></td><td></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ALWAYS_INSERT_MENU_TITLE;?>?</td>
	            <td width="150"><?php echo $lists['shAlwaysInsertMenuTitle'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_ALWAYS_INSERT_MENU_TITLE,
                _COM_SEF_SH_ALWAYS_INSERT_MENU_TITLE);?></td><td></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ALWAYS_INSERT_ITEMID;?>?</td>
	            <td width="150"><?php echo $lists['shAlwaysInsertItemid'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_ALWAYS_INSERT_ITEMID,
                _COM_SEF_SH_ALWAYS_INSERT_ITEMID);?></td><td></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_DEFAULT_MENU_ITEM_NAME;?></td>
	            <td width="150"><input type="text" name="shDefaultMenuItemName" value="<?php echo $sefConfig->shDefaultMenuItemName;?>" size="30" maxlength="30"></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_DEFAULT_MENU_ITEM_NAME,
                                         _COM_SEF_SH_DEFAULT_MENU_ITEM_NAME);?></td><td></td>
	        </tr>
	        <!-- shumisha 2007-04-01 end of new params for Itemid handling and URL construction  -->
	        
	        <!-- shumisha 19/08/2007 16:29:22 new params for upgrade management  -->
          <th colspan="4"><?php echo _COM_SEF_SH_UPGRADE_TITLE;?></th>  
          
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_UPGRADE_KEEP_CONFIG;?>?</td>
	            <td width="150"><?php echo $lists['shKeepConfigOnUpgrade'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_UPGRADE_KEEP_CONFIG,
                _COM_SEF_SH_UPGRADE_KEEP_CONFIG);?></td><td></td>
	        </tr>
          
           <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_UPGRADE_KEEP_URL;?>?</td>
	            <td width="150"><?php echo $lists['shKeepStandardURLOnUpgrade'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_UPGRADE_KEEP_URL,
                _COM_SEF_SH_UPGRADE_KEEP_URL);?></td><td></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_UPGRADE_KEEP_CUSTOM;?>?</td>
	            <td width="150"><?php echo $lists['shKeepCustomURLOnUpgrade'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_UPGRADE_KEEP_CUSTOM,
                _COM_SEF_SH_UPGRADE_KEEP_CUSTOM);?></td><td></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_UPGRADE_KEEP_META;?>?</td>
	            <td width="150"><?php echo $lists['shKeepMetaDataOnUpgrade'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_UPGRADE_KEEP_META,
                _COM_SEF_SH_UPGRADE_KEEP_META);?></td><td></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_UPGRADE_KEEP_MODULES;?>?</td>
	            <td width="150"><?php echo $lists['shKeepModulesSettingsOnUpgrade'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_UPGRADE_KEEP_MODULES,
                _COM_SEF_SH_UPGRADE_KEEP_MODULES);?></td><td></td>
	        </tr>

	        <!-- shumisha 19/08/2007 16:29:22 new params for upgrade management  -->
	        
  </table>        
  <?php        
	$tabs->endTab();
	}
	$tabs->startTab(_COM_SEF_SH_CONF_TAB_BY_COMPONENT,"ByComponent");
	
		echo '<table class="adminform">';
		echo '<tr align = "left" >'; 
	    echo "<td width=\"140px\" align=\"left\">&nbsp;</td>\n";
		echo "<td width=\"auto\" align=\"left\">&nbsp;".mosToolTip(_COM_SEF_TT_SH_ADV_MANAGE_URL,
             _COM_SEF_SH_ADV_MANAGE_URL)."</td>\n";
        if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) {     
			echo "<td width=\"auto\" align=\"left\">&nbsp;".mosToolTip(_COM_SEF_TT_SH_ADV_TRANSLATE_URL,
            	 _COM_SEF_SH_ADV_TRANSLATE_URL)."</td>\n";
			echo "<td width=\"auto\" align=\"left\">&nbsp;".mosToolTip(_COM_SEF_TT_SH_ADV_INSERT_ISO,
            	  _COM_SEF_SH_ADV_INSERT_ISO)."</td>\n";
    		echo "<td width=\"auto\" align=\"left\">&nbsp;".mosToolTip(_COM_SEF_TT_SH_ADV_OVERRIDE_SEF,
            	  _COM_SEF_SH_OVERRIDE_SEF_EXT)."</td>\n";
        	echo "<td width=\"auto\" align=\"left\">&nbsp;".mosToolTip(_COM_SEF_TT_SH_ADV_COMP_DEFAULT_STRING,
            	  _COM_SEF_SH_ADV_COMP_DEFAULT_STRING)."</td>\n";
        }    	        
	  	echo '</tr>';
		foreach($lists['adv_config'] as $key=>$compList) {
			$x++;
			echo '<tr'.(($x % 2) ? '':' class="row1"' )." colspan=\"6\">\n";
			echo '<td width="140px">'.$key."</td>\n";
			echo '<td width="auto">'.$compList['manageURL']."</td>\n";
			if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) {
				echo '<td width="auto">'.$compList['translateURL']."</td>\n";
				echo '<td width="auto">'.$compList['insertIsoCode']."</td>\n";
      			echo '<td width="auto">'.$compList['shDoNotOverrideOwnSef']."</td>\n";
      			echo $compList['defaultComponentString']."\n";
			}	
	    echo "</tr>\n";
		}
		echo '</table>';
     
	$tabs->endTab();
	$tabs->startTab(_COM_SEF_SH_CONF_TAB_META,"Title-Meta");
	?>
  <table class="adminform">
	      <tr>
	        <th colspan="3"><?php echo _COM_SEF_TITLE_META_MANAGEMENT;?></th>
	        </tr>
	        <tr >
	        <td colspan="3" align="left"><?php echo _COM_SEF_SH_CONF_META_DOC; ?></td>
	        </tr>
	        <!-- shumisha 2007-07-01 Activate Meta management  -->
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_META_MANAGEMENT_ACTIVATED;?>?</td>
	            <td width="150"><?php echo $lists['shMetaManagementActivated'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_META_MANAGEMENT_ACTIVATED,
                _COM_SEF_SH_META_MANAGEMENT_ACTIVATED);?></td>
	      </tr>	
	      <?php if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) { ?>  
	        <!-- shumisha 2007-07-01 Remove Joomla Generator tag  -->
          <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_REMOVE_JOOMLA_GENERATOR;?>?</td>
	            <td width="150"><?php echo $lists['shRemoveGeneratorTag'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_REMOVE_JOOMLA_GENERATOR,
                _COM_SEF_SH_REMOVE_JOOMLA_GENERATOR);?></td>
	      </tr>	
	        <!-- shumisha 2007-07-01 Put <h1>tags around content titles -->
	      <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_PUT_H1_TAG;?>?</td>
	            <td width="150"><?php echo $lists['shPutH1Tags'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_PUT_H1_TAG,
                _COM_SEF_SH_PUT_H1_TAG);?></td>
	      </tr>
	        <!-- shumisha 2007-11-09 shCustomTags new params V 1.3 RC  -->
	        <?php 
	        	$x++; echo HTML_sef::shYesNoParamHTML( $x, _COM_SEF_SH_MULTIPLE_H1_TO_H2, 
	        					_COM_SEF_TT_SH_MULTIPLE_H1_TO_H2, $lists['shMultipleH1ToH2']);
	        	$x++; echo HTML_sef::shYesNoParamHTML( $x, _COM_SEF_SH_INSERT_NOFOLLOW_PDF_PRINT,
	        					_COM_SEF_TT_SH_INSERT_NOFOLLOW_PDF_PRINT, $lists['shInsertNoFollowPDFPrint']);
	        	$x++; echo HTML_sef::shYesNoParamHTML( $x, _COM_SEF_SH_INSERT_READMORE_PAGE_TITLE, 
	        					_COM_SEF_TT_SH_INSERT_READMORE_PAGE_TITLE, $lists['shInsertReadMorePageTitle']);
	        } ?>
	</table>
	<?php        
	$tabs->endTab();
	$tabs->startTab(_COM_SEF_SH_CONF_TAB_SECURITY,"Title-Sec");
	?>
	<table class="adminform">
	        <tr>
	        <th colspan="3"><?php echo _COM_SEF_SH_SECURITY_TITLE;?></th>
	        </tr>
	        <!-- shumisha 2007-09-15 Activate Security  -->
			<tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ACTIVATE_SECURITY;?>?</td>
	            <td width="150"><?php echo $lists['shSecEnableSecurity'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_ACTIVATE_SECURITY,
                _COM_SEF_SH_ACTIVATE_SECURITY);?></td>
	        </tr>	
	        <?php if ($sefConfig->shAdminInterfaceType == SH404SEF_ADVANCED_ADMIN) { ?> 
			<tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_LOG_ATTACKS;?>?</td>
	            <td width="150"><?php echo $lists['shSecLogAttacks'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_LOG_ATTACKS,
                _COM_SEF_SH_LOG_ATTACKS);?></td>
	        </tr>	
      		<tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_MONTHS_TO_KEEP_LOGS;?></td>
	            <td width="150"><input type="text" name="monthsToKeepLogs" value="<?php echo $sefConfig->monthsToKeepLogs;?>" size="5" maxlength="2"></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_MONTHS_TO_KEEP_LOGS, _COM_SEF_SH_MONTHS_TO_KEEP_LOGS);?></td>
	        </tr>      	
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ONLY_NUM_VARS;?></td>
	            <td width="150"><textarea name="shSecOnlyNumVars" cols="20" rows="5"><?php echo $lists['shSecOnlyNumVars'];?></textarea></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_ONLY_NUM_VARS, _COM_SEF_SH_ONLY_NUM_VARS);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ONLY_ALPHA_NUM_VARS;?></td>
	            <td width="150"><textarea name="shSecAlphaNumVars" cols="20" rows="5"><?php echo $lists['shSecAlphaNumVars'];?></textarea></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_ONLY_ALPHA_NUM_VARS, _COM_SEF_SH_ONLY_ALPHA_NUM_VARS);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_NO_PROTOCOL_VARS;?></td>
	            <td width="150"><textarea name="shSecNoProtocolVars" cols="20" rows="5"><?php echo $lists['shSecNoProtocolVars'];?></textarea></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_NO_PROTOCOL_VARS, _COM_SEF_SH_NO_PROTOCOL_VARS);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_IP_WHITE_LIST;?></td>
	            <td width="150"><textarea name="ipWhiteList" cols="20" rows="5"><?php echo $lists['ipWhiteList'];?></textarea></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_IP_WHITE_LIST, _COM_SEF_SH_IP_WHITE_LIST);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_IP_BLACK_LIST;?></td>
	            <td width="150"><textarea name="ipBlackList" cols="20" rows="5"><?php echo $lists['ipBlackList'];?></textarea></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_IP_BLACK_LIST, _COM_SEF_SH_IP_BLACK_LIST);?></td>
	        </tr>
	
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_UAGENT_WHITE_LIST;?></td>
	            <td width="150"><textarea name="uAgentWhiteList" cols="60" rows="5"><?php echo $lists['uAgentWhiteList'];?></textarea></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_UAGENT_WHITE_LIST, _COM_SEF_SH_UAGENT_WHITE_LIST);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_UAGENT_BLACK_LIST;?></td>
	            <td width="150"><textarea name="uAgentBlackList" cols="60" rows="5"><?php echo $lists['uAgentBlackList'];?></textarea></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_UAGENT_BLACK_LIST, _COM_SEF_SH_UAGENT_BLACK_LIST);?></td>
	        </tr>
	        
	        <th colspan="3"><?php echo _COM_SEF_SH_ANTIFLOOD_TITLE;?></th>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ACTIVATE_ANTIFLOOD;?>?</td>
	            <td width="150"><?php echo $lists['shSecActivateAntiFlood'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_ACTIVATE_ANTIFLOOD,
                _COM_SEF_SH_ACTIVATE_ANTIFLOOD);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ANTIFLOOD_ONLY_ON_POST;?>?</td>
	            <td width="150"><?php echo $lists['shSecAntiFloodOnlyOnPOST'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_ANTIFLOOD_ONLY_ON_POST,
                _COM_SEF_SH_ANTIFLOOD_ONLY_ON_POST);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ANTIFLOOD_PERIOD;?></td>
	            <td width="150"><input type="text" name="shSecAntiFloodPeriod" value="<?php echo $sefConfig->shSecAntiFloodPeriod;?>" size="5" maxlength="5"></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_ANTIFLOOD_PERIOD, _COM_SEF_SH_ANTIFLOOD_PERIOD);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_ANTIFLOOD_COUNT;?></td>
	            <td width="150"><input type="text" name="shSecAntiFloodCount" value="<?php echo $sefConfig->shSecAntiFloodCount;?>" size="5" maxlength="5"></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_ANTIFLOOD_COUNT, _COM_SEF_SH_ANTIFLOOD_COUNT);?></td>
	        </tr>
	        
	        
	        <th colspan="3"><?php echo _COM_SEF_SH_HONEYPOT_TITLE;?></th>
	        </tr>
	        <tr >
	        <td colspan="3" align="left"><?php echo _COM_SEF_SH_CONF_HONEYPOT_DOC; ?></td>
	        </tr>
			<tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_CHECK_HONEY_POT;?>?</td>
	            <td width="150"><?php echo $lists['shSecCheckHoneyPot'];?></td>
	            <td><?php echo mosToolTip(_COM_SEF_TT_SH_CHECK_HONEY_POT,
                _COM_SEF_SH_CHECK_HONEY_POT);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_HONEYPOT_KEY;?></td>
	            <td width="150"><input type="text" name="shSecHoneyPotKey" value="<?php echo $sefConfig->shSecHoneyPotKey;?>" size="30" maxlength="30"></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_HONEYPOT_KEY, _COM_SEF_SH_HONEYPOT_KEY);?></td>
	        </tr>
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_HONEYPOT_ENTRANCE_TEXT;?></td>
	            <td width="150"><textarea name="shSecEntranceText" cols="60" rows="5"><?php echo $sefConfig->shSecEntranceText;?></textarea></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_HONEYPOT_ENTRANCE_TEXT, _COM_SEF_SH_HONEYPOT_ENTRANCE_TEXT);?></td>
	        </tr>	        
	        <tr<?php $x++; echo (($x % 2) ? '':' class="row1"' );?>>
	            <td width="200"><?php echo _COM_SEF_SH_SMELLYPOT_TEXT;?></td>
	            <td width="150"><textarea name="shSecSmellyPotText" col="60" rows="5"><?php echo $sefConfig->shSecSmellyPotText;?></textarea></td>
	            <td><?php echo mosToolTip( _COM_SEF_TT_SH_SMELLYPOT_TEXT, _COM_SEF_SH_SMELLYPOT_TEXT);?></td>
	        </tr>
	        <?php } ?>
	</table>
	
	<?php 
	$tabs->endPane();
	?>       
	        <input type="hidden" name="id" value="">
	        <input type="hidden" name="task" value="saveconfig">
	        <input type="hidden" name="option" value="com_sef">
	        <input type="hidden" name="section" value="config">
	        <input type="hidden" name="eraseCache" id="eraseCache" value="0">
	    </form>
    <?php
	}
	
	function viewSEF( &$rows, &$lists, $pageNav, $option, $viewmode=0, $search = '' ) { 
  // V 1.2.4.q added search
	
	global $my;
	
		?>
				<script language="Javascript">
				    function submitbutton(pressbutton) {
				      if (((pressbutton != 'viewDuplicates') && (pressbutton != 'newMetaFromSEF')) 
                   || (pressbutton == 'newMetaFromSEF') && (document.adminForm.boxchecked.value == 1) 
                   || (pressbutton == 'viewDuplicates') && (document.adminForm.boxchecked.value == 1))
                submitform( pressbutton );  
	            else alert("<?php echo _COM_SEF_SELECT_ONE_URL; ?>");
					}
					//-->
					</script>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo _COM_SEF_TITLE_MANAGER;?>
			<br/><font class="small" align="left"><a href="index2.php?option=com_sef"><?php echo _COM_SEF_BACK?></a></font>
			</th>
			<td nowrap >
			<?php
			if ($viewmode == 2) {
			?><br/>
			<a href="index2.php?option=<?php echo $option; ?>&task=import_export&ViewModeId=<?php echo $viewmode?>"><?php echo _COM_SEF_IMPORT_EXPORT; ?></a>&nbsp;&nbsp;
			<?php }else{
			?>
			&nbsp;
			</td>
			<?php }
			?>
			<td width="right">
			<?php echo _COM_SEF_VIEWMODE.$lists['viewmode'];?>
			</td>
			<td width="right">
			<?php echo _COM_SEF_SORTBY.$lists['sortby'];?>
			</td>
			
			<td align="left">
			<?php echo _COM_SEF_SH_FILTER.':'; ?> <br />
			<input type="text" name="search" value="<?php echo htmlspecialchars( $search );?>" class="text_area" onChange="document.adminForm.submit();" />
			</td>
			
		</tr>
		</table>
		<table class="adminlist">
		<tr>
			<th width="20px">
			#
			</th>
			<th width="20px">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title" width="50px">
			<?php echo _COM_SEF_HITS;?>
			</th>
			<th class="title">
			<?php echo (($viewmode == 1) ? _COM_SEF_DATEADD: _COM_SEF_SEFURL) ?>
			</th>
			<th>
			<?php echo (($viewmode == 1) ? _COM_SEF_URL:_COM_SEF_REALURL ) ?>
			</th>
		</tr>
		<?php
		$k = 0;
		//for ($i=0, $n=count( $rows ); $i < $n; $i++) {
		if (!empty($rows))
		foreach (array_keys($rows) as $i) {
			$row = &$rows[$i];
			?>
			<tr class="<?php echo 'row'. $k; ?>">
				<td align="center">
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id, false ); ?>
				</td>
				<td>
				<?php echo $row->cpt; ?>
				</td>
				<td style="text-align:left;">
				<?php if ($viewmode == 1) {?>
					<?php echo $row->dateadd;?>
				<?php }else{ ?>
					<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
					<?php echo $row->oldurl;?>
					</a>
				<?php } ?>
				</td>
				<td style="text-align:left;" width="80%">
				<?php if ($viewmode == 1) {?>
					<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
					<?php echo $row->oldurl;?>
					</a>
				<?php }else echo htmlspecialchars($row->newurl);?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="view" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		<?php
	}
	
	function viewDuplicates( &$rows, &$lists, $pageNav, $option, $id ) { 
	
		?>
				<script language="Javascript">
				    function submitbutton(pressbutton) {
				      if ((pressbutton != 'makeMainUrl') 
                   || (pressbutton == 'makeMainUrl') && (document.adminForm.boxchecked.value == 1))
                submitform( pressbutton );  
	            else alert("<?php echo _COM_SEF_SELECT_ONE_URL; ?>");
					}
					//-->
					</script>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo _COM_SEF_MANAGE_DUPLICATES.$rows[0]->oldurl; ?>
			<br/><font class="small" align="left"><a href="index2.php?option=com_sef"><?php echo _COM_SEF_BACK?></a></font>
			</th>

			<td width="right">
			<?php echo _COM_SEF_SORTBY.$lists['sortby'];?>
			</td>
			
		</tr>
		</table>
		<table class="adminlist">
		<tr>
			<th width="20px">
			#
			</th>
			<th width="20px">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title" width="50px">
			<?php echo _COM_SEF_MANAGE_DUPLICATES_RANK;?>
			</th>
			<th>
			<?php echo _COM_SEF_REALURL; ?>
			</th>
		</tr>
		<?php
		$k = 0;
		//for ($i=0, $n=count( $rows ); $i < $n; $i++) {
		foreach (array_keys($rows) as $i) {
			$row = &$rows[$i];
			?>
			<tr class="<?php echo 'row'. $k; ?>">
				<td align="center">
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id, false ); ?>
				</td>
				<td>
				<?php echo $row->rank; ?>
				</td>
				<td style="text-align:left;" width="80%">
					<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','makeMainUrl')">
					<?php echo htmlspecialchars($row->newurl);?>
					</a>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="id" value="<?php echo $id;?>" />
		<input type="hidden" name="task" value="viewDuplicates" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		<?php
	}
	
	function editSEF( &$_row, &$lists, $_option ) {
	
?>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	<script language="Javascript" src="<?php echo $GLOBALS['mosConfig_live_site']; ?>/includes/js/overlib_mini.js"></script>
	<script language="javascript">
	<!--
	function changeDisplayImage() {
		if (document.adminForm.imageurl.value !='') {
			document.adminForm.imagelib.src='../images/404sef/' + document.adminForm.imageurl.value;
		} else {
			document.adminForm.imagelib.src='images/blank.png';
		}
	}
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if (form.oldurl.value == "") {
			alert( "<?php echo _COM_SEF_EMPTYURL?>" );
      	} 
<?php if ( (!$_row->id) || $_row->dateadd != "0000-00-00" )  { ?>        
        else {
			if (form.newurl.value.match(/^index.php/)) {
			  form.dateadd.value = "<?php echo date('Y-m-d'); ?>"  // V 1.2.4.s  always custom URL
				submitform( pressbutton );
			}else{
				alert( "<?php echo _COM_SEF_BADURL ?>" );
			}
		}
<?php } else {?>
else
  submitform( pressbutton );
<?php }?>		
	}
	//-->
	</script>
	<table class="adminheading">
		<tr>
			<th><?php echo $_row->id ? _COM_SEF_EDIT : _COM_SEF_ADD;?> Url</th>
		</tr>
	</table>
	<form action="index2.php" method="post" name="adminForm">
	<table class="adminform">
		<tr>
			<td width="20%"><?php echo _COM_SEF_OLDURL;?></td>
			<td width="70%"><input class="inputbox" type="text" size="100" name="oldurl" value="<?php echo $_row->oldurl; ?>">
			<?php echo mosToolTip(_COM_SEF_TT_OLDURL);?></td>
			<td width="10%">&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _COM_SEF_NEWURL;?></td>
			<?php if ( ($_row->id) && $_row->dateadd == "0000-00-00" ) { ?>
			<td width="70%"><?php echo htmlspecialchars($_row->newurl); ?></td>
      <?php } else { ?>
			<td width="70%"><input class="inputbox" type="text" size="100" name="newurl" value="<?php echo htmlspecialchars($_row->newurl); ?>">
			<?php echo mosToolTip(_COM_SEF_TT_NEWURL); ?></td> <?php } ?>
			<td width="10%">&nbsp;</td>
		</tr>
	</table>
	<input type="hidden" name="option" value="<?php echo $_option; ?>">
	<?php if ( ($_row->id) && $_row->dateadd == "0000-00-00" ) { ?>
	  <input type="hidden" name="newurl" value="<?php echo $_row->newurl; ?>">
	  <input type="hidden" name="dateadd" value="<?php echo date('Y-m-d'); ?>">
	<?php } else {?>
	  <input type="hidden" name="dateadd" value="<?php echo $_row->dateadd; ?>">
	<?php }  ?>
	<input type="hidden" name="id" value="<?php echo $_row->id; ?>">
	<input type="hidden" name="returnTo" value="1">
	<input type="hidden" name="task" value="">
	</form>
<?php
	}
	
	function viewMeta( &$rows, &$lists, $pageNav, $option, $search = '' ) { 
  // V 1.2.4.s
	
	global $my;
	
		?>

		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo _COM_SEF_TITLE_META_MANAGEMENT;?>
			<br/><font class="small" align="left"><a href="index2.php?option=com_sef"><?php echo _COM_SEF_BACK?></a></font>
			</th>
			<td nowrap >
      <br/>
			<a href="index2.php?option=<?php echo $option; ?>&task=import_export_meta"><?php echo _COM_SEF_IMPORT_EXPORT_META; ?></a>&nbsp;&nbsp;
			</td>
			<td width="right">
			</td>
			<td width="right">
			<?php echo _COM_SEF_SORTBY.$lists['sortby'];?>
			</td>
			
			<td align="left">
			<?php echo _COM_SEF_SH_FILTER.':'; ?> <br />
			<input type="text" name="searchMeta" value="<?php echo htmlspecialchars( $search );?>" class="text_area" onChange="document.adminForm.submit();" />
			</td>
			
		</tr>
		</table>
		<table class="adminlist">
		<tr>
			<th width="20px">
			#
			</th>
			<th width="20px">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th>
			<?php echo _COM_SEF_REALURL; ?>
			</th>
		</tr>
		<?php
		$k = 0;
		//for ($i=0, $n=count( $rows ); $i < $n; $i++) {
		foreach (array_keys($rows) as $i) {
			$row = &$rows[$i];
			?>
			<tr class="<?php echo 'row'. $k; ?>">
				<td align="center">
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id, false ); ?>
				</td>
				<td style="text-align:left;">
				
					<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
					<?php echo htmlspecialchars($row->newurl);?>
					</a>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="viewMeta" />
		<input type="hidden" name="section" value="meta" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="returnTo" value="0">
		</form>
		<?php
	}
	
	function editMeta( &$_row, $_option, $returnTo, $editUrl, $oldUrl ) {
	
?>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	<script language="Javascript" src="<?php echo $GLOBALS['mosConfig_live_site']; ?>/includes/js/overlib_mini.js"></script>
	<script language="javascript">
	<!--
	function changeDisplayImage() {
		if (document.adminForm.imageurl.value !='') {
			document.adminForm.imagelib.src='../images/404sef/' + document.adminForm.imageurl.value;
		} else {
			document.adminForm.imagelib.src='images/blank.png';
		}
	}
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if (pressbutton == 'deleteHomeMeta' || pressbutton == 'deleteHomeMetaFromSEF') {
		  if (confirm("<?php echo _COM_SEF_CONF_ERASE_HOME_META?>" )) {
			  submitform( pressbutton );
			  return;
			} else return;
		}
		
		// do field validation
		if (form.newurl.value == "") {
			alert( "<?php echo _COM_SEF_EMPTYURL?>" );
		} else {
			if (  <?php echo empty($editUrl) ? 1 : 0; ?> 
         || form.newurl.value.match(/index.php/)) {
				submitform( pressbutton );
				return;
			}else{
				alert( "<?php echo _COM_SEF_BAD_META?>" );
			}
		}
	}
	//-->
	</script>
	<table class="adminheading">
		<tr>
			<th><?php echo ($_row->id ? _COM_SEF_META_EDIT : _COM_SEF_META_ADD).(empty($oldUrl) ? '': ' : '.$oldUrl); ?></th>
		</tr>
	</table>
	<form action="index2.php" method="post" name="adminForm">
	<table class="adminform">
	  <?php if (!empty($editUrl)) {  // V 1.2.4.t ?>
		<tr>
			<td width="20%"><?php echo _COM_SEF_NEWURL_META;?></td>
			<td width="70%"><input class="inputbox" type="text" size="100" name="newurl" value="<?php echo htmlspecialchars($_row->newurl); ?>">
			<?php echo mosToolTip(_COM_SEF_TT_NEWURL_META);?></td>
			<td width="10%">&nbsp;</td>
		</tr>
		<?php } else {?>
		  <input type="hidden" name="newurl" value="<?php echo htmlspecialchars($_row->newurl); ?>">
		<?php } ?>
		<tr>
			<td width="20%"><?php echo _COM_SEF_META_TITLE;?></td>
			<td width="70%"><input class="inputbox" type="text" size="100" name="metatitle" value="<?php echo $_row->metatitle; ?>">
			<?php echo mosToolTip(_COM_SEF_TT_META_TITLE);?></td>
			<td width="10%">&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _COM_SEF_META_DESC;?></td>
			<td width="70%"><input class="inputbox" type="text" size="100" name="metadesc" value="<?php echo $_row->metadesc; ?>">
			<?php echo mosToolTip(_COM_SEF_TT_META_DESC);?></td>
			<td width="10%">&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _COM_SEF_META_KEYWORDS;?></td>
			<td width="70%"><input class="inputbox" type="text" size="100" name="metakey" value="<?php echo $_row->metakey; ?>">
			<?php echo mosToolTip(_COM_SEF_TT_META_KEYWORDS);?></td>
			<td width="10%">&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _COM_SEF_META_ROBOTS;?></td>
			<td width="70%"><input class="inputbox" type="text" size="30" name="metarobots" value="<?php echo $_row->metarobots; ?>">
			<?php echo mosToolTip(_COM_SEF_TT_META_ROBOTS);?></td>
			<td width="10%">&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _COM_SEF_META_LANG;?></td>
			<td width="70%"><input class="inputbox" type="text" size="30" name="metalang" value="<?php echo $_row->metalang; ?>">
			<?php echo mosToolTip(_COM_SEF_TT_META_LANG);?></td>
			<td width="10%">&nbsp;</td>
		</tr>
	</table>
	<input type="hidden" name="option" value="<?php echo $_option; ?>">
	<input type="hidden" name="id" value="<?php echo $_row->id; ?>">
	<input type="hidden" name="section" value="meta">
	<input type="hidden" name="task" value="">
	<input type="hidden" name="returnTo" value="<?php echo $returnTo; ?>">
	</form>
<?php
	}
	
	
	function help(){
	
	?>
		 <table class="adminform">
	        <tr>
	            <th colspan="4"><?php echo _COM_SEF_TITLE_SUPPORT;?></th>
	        </tr>
	        <tr>
	        	<td>
<?php global $mosConfig_absolute_path; include( $mosConfig_absolute_path.'/administrator/components/com_sef/readme.inc'); ?>
            </td>
	        </tr>
	<?php
	}
	
	function purge($option, $message, $confirmed){
	
	?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo _COM_SEF_TITLE_PURGE;?>
			<br/><font class="small" align="left"><a href="index2.php?option=com_sef"><?php echo _COM_SEF_BACK?></a></font>
			</th>
		</tr>
		<tr>
			<td><p class="message"><?php echo $message ?><br/>
				<input type="hidden" name="option" value="<?php echo $option;?>" />
			<?php if (($message == _COM_SEF_SUCCESSPURGE)||($message == _COM_SEF_NORECORDS)) { ?>
				<input type="hidden" name="task" value="" />
				<input type="submit" name="continue" value="<?php echo _COM_SEF_OK ?>"</p>
			<?php }else{ ?>
				<input type="hidden" name="task" value="purge" />
				<input type="submit" name="confirmed" value="<?php echo _COM_SEF_PROCEED; ?>" /></p>
			<?php } ?>
			</td>
		</tr>
	<?php
	}
	
	function purgeMeta($option, $message, $confirmed){
	
	?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo _COM_SEF_META_TITLE_PURGE;?>
			<br/><font class="small" align="left"><a href="index2.php?option=com_sef"><?php echo _COM_SEF_BACK?></a></font>
			</th>
		</tr>
		<tr>
			<td><p class="message"><?php echo $message ?><br/>
				<input type="hidden" name="option" value="<?php echo $option;?>" />
			<?php if (($message == _COM_SEF_META_SUCCESS_PURGE)||($message == _COM_SEF_NORECORDS)) { ?>
				<input type="hidden" name="task" value="" />
				<input type="submit" name="continue" value="<?php echo _COM_SEF_OK ?>"</p>
			<?php }else{ ?>
				<input type="hidden" name="task" value="purgeMeta" />
				<input type="submit" name="confirmed" value="<?php echo _COM_SEF_PROCEED ?>"</p>
			<?php } ?>
			</td>
		</tr>
	<?php
	}
	
	function import_export( $ViewModeId = 0) {
	
?>
<script type="text/javascript">
function checkForm(){
if (document.backupform.userfile.value == ""){
alert('<?php echo _COM_SEF_SELECT_FILE; ?>');
return false;
}else{
return true;
}
}
function toggle_display(idname){
obj = fetch_object(idname);
if (obj){
if (obj.style.display == "none"){
obj.style.display = "";
}else{
obj.style.display = "none";
}
}
return false;
}
</script>
		<table class="adminheading">
		<tr>
			<th>
			<?php echo $ViewModeId == 2 ? _COM_SEF_IMPORT_EXPORT_CUSTOM:str_replace( '<br />',' ', _COM_SEF_IMPORT_EXPORT); ?>
			<br/><font class="small" align="left"><a href="index2.php?option=com_sef"><?php echo _COM_SEF_BACK?></a></font>
			</th>
		</tr>
<table width ="100%" align="left" border="0" cellpadding="0" cellspacing="25px">
<tr width ="100%"><td>
<form method="post" action="index2.php?option=com_sef&task=import&ViewModeId=<?php echo $ViewModeId; ?>" enctype="multipart/form-data" onSubmit="return checkForm();" name="backupform">
<input type="file" name="userfile">
<input type="submit" value="<?php echo ($ViewModeId == 2 ? _COM_SEF_IMPORT : _COM_SEF_IMPORT_ALL); ?>">
</form>
</td></tr>
<tr width ="100%"><td>
<form method="post" action="index2.php?option=com_sef&task=importOpenSEF&ViewModeId=<?php echo $ViewModeId; ?>" enctype="multipart/form-data" onSubmit="return checkForm();" name="backupform">
<input type="file" name="userfile">
<input type="submit" value="<?php echo _COM_SEF_IMPORT_OPEN_SEF; ?>">
</form>
</td></tr>
<tr width ="100%"><td>
<input type="button" value="<?php echo ($ViewModeId == 2 ? _COM_SEF_EXPORT : _COM_SEF_EXPORT_ALL); ?>" onClick="javascript:location.href='index2.php?option=com_sef&task=export&ViewModeId=<?php echo $ViewModeId;?>'"></center>
</td></tr>
</table>
<?php
	}
	
		function import_export_meta( ) {
	
?>
<script type="text/javascript">
function checkForm(){
if (document.backupform.userfile.value == ""){
alert('<?php echo _COM_SEF_SELECT_FILE; ?>');
return false;
}else{
return true;
}
}
function toggle_display(idname){
obj = fetch_object(idname);
if (obj){
if (obj.style.display == "none"){
obj.style.display = "";
}else{
obj.style.display = "none";
}
}
return false;
}
</script>
<center>
<form method="post" action="index2.php?option=com_sef&task=import_meta" enctype="multipart/form-data" onSubmit="return checkForm();" name="backupform">
<input type="file" name="userfile">
<input type="submit" value="<?php echo _COM_SEF_IMPORT_META; ?>">
</form>
<br />
<input type="button" value="<?php echo _COM_SEF_EXPORT_META; ?>" onClick="javascript:location.href='index2.php?option=com_sef&task=export_meta'"></center>
<br />

<?php
	}
	
	
}
?>
