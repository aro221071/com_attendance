<?php
/**
 * @version     2.0.0
 * @package     com_attendance
 * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Artelsmair Roman <aroaro@gmx.at> - http://artelsmair.at
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_attendance/assets/css/attendance.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'type.cancel') {
            Joomla.submitform(task, document.getElementById('type-form'));
        }
        else {
            
            if (task != 'type.cancel' && document.formvalidator.isValid(document.id('type-form'))) {
                
                Joomla.submitform(task, document.getElementById('type-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_attendance&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="type-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_ATTENDANCE_TITLE_TYPE', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

				<?php } 
				else{ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

				<?php } ?>			
          
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('shortname'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('shortname'); ?></div>
			</div>
			
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('longname'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('longname'); ?></div>
			</div>
			
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('players_male'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('players_male'); ?></div>
			</div>
			
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('players_female'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('players_female'); ?></div>
			</div>
			
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('players_whatever'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('players_whatever'); ?></div>
			</div>
			
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('sortkey'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('sortkey'); ?></div>
			</div>
			
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('published'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('published'); ?></div>
			</div>
			
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created'); ?></div>
			</div>
			
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('creator'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('creator'); ?></div>
			</div>
			
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('modified'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('modified'); ?></div>
			</div>
			
      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('modifier'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('modifier'); ?></div>
			</div>
          
    </fieldset>
  </div>
</div>

<?php echo JHtml::_('bootstrap.endTab'); ?>
<?php echo JHtml::_('bootstrap.endTabSet'); ?>
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>