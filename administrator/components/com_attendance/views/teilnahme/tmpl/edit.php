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
  $document->addStyleSheet('components/com_attendance/assets/css/attendance_admin.css');
?>

<script type="text/javascript">
  js = jQuery.noConflict();
  js(document).ready
  (
    function() 
    {
      js('input:hidden.type').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('typehidden'))
          {
            js('#jform_type option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_type").trigger("liszt:updated");
      js('input:hidden.club').each
      (
        function()
        {
          var name = js(this).attr('name');
          if(name.indexOf('clubhidden'))
          {
            js('#jform_club option[value="'+js(this).val()+'"]').attr('selected',true);
          }
        }
      );
      js("#jform_club").trigger("liszt:updated");
    }
  );

  Joomla.submitbutton = function(task)
  {
    if (task == 'teilnahme.cancel') 
    {
      Joomla.submitform(task, document.getElementById('teilnahme-form'));
    }
    else 
    {
      if (task != 'teilnahme.cancel' && document.formvalidator.isValid(document.id('teilnahme-form'))) 
      {
        Joomla.submitform(task, document.getElementById('teilnahme-form'));
      }
      else 
      {
        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
      }
    }
  }
</script>


<form action="<?php echo JRoute::_('index.php?option=com_attendance&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="teilnahme-form" class="form-validate">

  <div class="form-horizontal">
    
    <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

      <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_ATTENDANCE_TITLE_TEILNAHME', true)); ?>
        <div class="row-fluid">
          <div class="span10 form-horizontal">
            <fieldset class="adminform">

              <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
              
              <div class="control-group"   id="control_date">
                <div class="control-label" id="label_date"><?php echo $this->form->getLabel('date'); ?></div>
                <div class="controls"      id="data_date"><?php echo $this->form->getInput('date'); ?></div>
              </div>
              <div class="control-group"   id="control_year">
                <div class="control-label" id="label_year"><?php echo $this->form->getLabel('year'); ?></div>
                <div class="controls"      id="data_year"><?php echo $this->form->getInput('year'); ?></div>
              </div>
              <div class="control-group"   id="control_number">
                <div class="control-label" id="label_number"><?php echo $this->form->getLabel('number'); ?></div>
                <div class="controls"      id="data_number"><?php echo $this->form->getInput('number'); ?></div>
              </div>

              <div class="control-group"   id="control_club">
                <div class="control-label" id="label_club_"><?php echo $this->form->getLabel('club'); ?></div>
                <div class="controls"      id="data_club"><?php echo $this->form->getInput('club'); ?></div>
              </div>
              <?php
                foreach((array)$this->item->club as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="club" id="data__club" name="jform[typehidden]['.$value.']" value="'.$value.'" />';
                  endif;
                endforeach;
              ?>			

              <div class="control-group"   id="control_name">
                <div class="control-label" id="label_name"><?php echo $this->form->getLabel('name'); ?></div>
                <div class="controls"      id="data_name"><?php echo $this->form->getInput('name'); ?></div>
              </div>

              <div class="control-group"   id="control_type">
                <div class="control-label" id="label_type_"><?php echo $this->form->getLabel('type'); ?></div>
                <div class="controls"      id="data_type"><?php echo $this->form->getInput('type'); ?></div>
              </div>
              <?php
                foreach((array)$this->item->type as $value): 
                  if(!is_array($value)):
                    echo '<input type="hidden" class="type" id="data__type" name="jform[typehidden]['.$value.']" value="'.$value.'" />';
                  endif;
                endforeach;
              ?>			

              <div class="control-group"   id="control_mode">
                <div class="control-label" id="label_mode"><?php echo $this->form->getLabel('mode'); ?></div>
                <div class="controls"      id="data_mode"><?php echo $this->form->getInput('mode'); ?></div>
              </div>

              <div class="control-group"   id="control_driver">
                <div class="control-label" id="label_driver"><?php echo $this->form->getLabel('driver'); ?></div>
                <div class="controls"      id="data_driver"><?php echo $this->form->getInput('driver'); ?></div>
              </div>
              <div class="control-group"   id="control_team">
                <div class="control-label" id="label_team"><?php echo $this->form->getLabel('team'); ?></div>
                <div class="controls"      id="data_team"><?php echo $this->form->getInput('team'); ?></div>
              </div>

              <div class="control-group"   id="control_place">
                <div class="control-label" id="label_place"><?php echo $this->form->getLabel('place'); ?></div>
                <div class="controls"      id="data_place"><?php echo $this->form->getInput('place'); ?></div>
              </div>
              <div class="control-group"   id="control_teams">
                <div class="control-label" id="label_teams"><?php echo $this->form->getLabel('teams'); ?></div>
                <div class="controls"      id="data_teams"><?php echo $this->form->getInput('teams'); ?></div>
              </div>

              <div class="control-group"   id="control_distance">
                <div class="control-label" id="label_distance"><?php echo $this->form->getLabel('distance'); ?></div>
                <div class="controls"      id="data_distance"><?php echo $this->form->getInput('distance'); ?></div>
              </div>
              <div class="control-group"   id="control_fare">
                <div class="control-label" id="label_fare"><?php echo $this->form->getLabel('fare'); ?></div>
                <div class="controls"      id="data_fare"><?php echo $this->form->getInput('fare'); ?></div>
              </div>

              <div class="control-group"   id="control_fee">
                <div class="control-label" id="label_fee"><?php echo $this->form->getLabel('fee'); ?></div>
                <div class="controls"      id="data_fee"><?php echo $this->form->getInput('fee'); ?></div>
              </div>
              <div class="control-group"   id="control_currency">                
                <div class="control-label" id="label_currency"><?php echo $this->form->getLabel('currency'); ?></div>
                <div class="controls"      id="data_currency"><?php echo $this->form->getInput('currency'); ?></div>
              </div>

              <div class="control-group"   id="control_published">
                <div class="control-label" id="label_published"><?php echo $this->form->getLabel('published'); ?></div>
                <div class="controls"      id="data_published"><?php echo $this->form->getInput('published'); ?></div>
              </div>
              <div class="control-group"   id="control_sortkey">
                <div class="control-label" id="label_sortkey"><?php echo $this->form->getLabel('sortkey'); ?></div>
                <div class="controls"      id="data_sortkey"><?php echo $this->form->getInput('sortkey'); ?></div>
              </div>

              <div class="control-group"   id="control_comment">
                <div class="control-label" id="label_comment"><?php echo $this->form->getLabel('comment'); ?></div>
                <div class="controls"      id="data_comment"><?php echo $this->form->getInput('comment'); ?></div>
              </div>

              <input type="hidden" name="jform[ordering]"         value="<?php echo $this->item->ordering; ?>" />
              <input type="hidden" name="jform[state]"            value="<?php echo $this->item->state; ?>" />
              <input type="hidden" name="jform[checked_out]"      value="<?php echo $this->item->checked_out; ?>" />
              <input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

              <?php 
                if(empty($this->item->created_by)){ ?>
                  <input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
              <?php } 
                else{ ?>
                  <input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
              <?php } ?>

            </fieldset>
          </div>
        </div>
      <?php echo JHtml::_('bootstrap.endTab'); ?>
        
    <?php echo JHtml::_('bootstrap.endTabSet'); ?>

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>

  </div>
</form>