<?php

namespace app\vendor\penblu\fullcalendar;

use Yii;
use app\vendor\penblu\fullcalendar\FullCalendarAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

/**
 * This is just an example.
 */
class FullCalendar extends \yii\base\Widget
{
    /**
     * @var string $lang the language for default
     */
    public $lang = 'en';
    /**
     * @var string $initDate Date by Default
     */
    public $initDate = '';
    /**
     * @var string $containerId the container Id to render the visualization to
     */
    public $containerId = "";
    /**
     * @var array $htmlOptions additional configuration options
     */
    public $htmlOptions = array();
    /**
     * @var array $isEditable Is editable calendar
     */
    public $isEditable = "false";
    /**
     * @var array $navLinks Show nav links of calendar
     */
    public $navLinks = "true";
    /**
     * @var array $eventLimit show event limit of calendar
     */
    public $eventLimit = "true";
    /**
     * @var array $weekNumbers show number weeks of calendar
     */
    public $weekNumbers = "false";
    /**
     * @var array $uriServer Load events from external URL
     */
    public $uriServer = "";
    /**
     * @var array $callbackFnFail function to execute if uriServer Fail
     */
    public $callbackFnFail = "void";
    /**
     * @var array $callbackFnLoad function to loading of uriServer Load
     */
    public $callbackFnLoad = "void";
    /**
     * @var array $dataEvents Load events from json data
     * EXAMPLE: 
     * [
        {
          title: 'All Day Event',
          start: '2020-02-01',
        },
        {
          title: 'Long Event',
          start: '2020-02-07',
          end: '2020-02-10'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-02-09T16:00:00'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-02-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2020-02-11',
          end: '2020-02-13'
        },
        {
          title: 'Meeting',
          start: '2020-02-12T10:30:00',
          end: '2020-02-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2020-02-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2020-02-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2020-02-12T17:30:00',
          backgroundColor: '#f56954',
          borderColor    : '#f56954',
          allDay         : true
        },
        {
          title: 'Dinner',
          start: '2020-02-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2020-02-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2020-02-28'
        }
      ]
     */
    public $dataEvents = "";
    /**
     * @var array $buttonIcons show button of calendar
     */
    public $buttonIcons = "true";
    /**
     * @var array $maxWidth Change MaxWidth style of calendar
     */
    public $maxWidth = "900px";
    /**
     * @var array $margin Change margin style of calendar
     */
    public $margin = "40px auto";
    /**
     * @var array $padding Change padding style of calendar
     */
    public $padding = "0 10px";
    /**
     * @var array $selectable Allow Select items of calendar
     */
    public $selectable = "false";
    /**
     * @var array $dateClickFn Function to click date of calendar
     */
    public $dateClickFn = "";
    /**
     * @var array $eventClickFn Function to click event of calendar
     */
    public $eventClickFn = "";
    /**
     * @var array $selectMirror Allow Select items of calendar
     */
    public $selectMirror = "true";




    public function init() {
        if($this->initDate == '') 
            $this->initDate = date('Y-m-d');
        parent::init();
        FullCalendarAsset::register($this->getView());
    }
    
    public function run()
    {
        $id = $this->getId();
        $this->htmlOptions['id'] = 'div-fcal-' . ((isset($this->containerId))?($this->containerId):$id);
        $this->containerId = $this->htmlOptions['id'];
        echo '<div id="calendar-container"><div ' . Html::renderTagAttributes($this->htmlOptions) . '></div></div>';
        $this->registerClientScript($this->containerId);
        parent::run();
    }

    /**
     * Registers required scripts
     */
    public function registerClientScript($id) {
        $events = "";
        $fnclickdate = "";
        $fnclickevent = "";
        if(isset($this->uriServer) && $this->uriServer != ""){
            $events = "events: {
                url: '".$this->uriServer."',
                failure: function() {
                    ".$this->callbackFnFail."();
                }
              },
              loading: function(bool) {
                    ".$this->callbackFnLoad."(bool);
              }";
        }else{
            $events = "events: ". $this->dataEvents;
        }
        if(isset($this->dateClickFn) && $this->dateClickFn != ""){
            $fnclickdate = "dateClick: function() {
                ".$this->dateClickFn."();
              },";
        }
        if(isset($this->eventClickFn) && $this->eventClickFn != ""){
            $fnclickevent = "eventClick: function(arg) {
                ".$this->eventClickFn."(arg.event._def.publicId);
              },";
        }

        $script = "document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('".$id."');
        
            var calendar = new FullCalendar.Calendar(calendarEl, {
              plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
              header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'  //'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
              },
              locale: '".$this->lang."',
              defaultDate: '".$this->initDate."',
              buttonIcons: ".$this->buttonIcons.", // show the prev/next text
              editable: ".$this->isEditable.",
              navLinks: ".$this->navLinks.", // can click day/week names to navigate views
              eventLimit: ".$this->eventLimit.", // allow 'more' link when too many events
              weekNumbers: ".$this->weekNumbers.",
              selectable: ".$this->selectable.",
              selectMirror: ".$this->selectMirror.",
              ".$fnclickdate."
              ".$fnclickevent."
              ".$events."
            });
            calendar.render();
          });";
        $css = "  
          #".$id." {
            max-width: ".$this->maxWidth.";
            margin: ".$this->margin.";
            padding: ".$this->padding.";
          }
          td.fc-widget-header:first-child, td.fc-widget-content:first-child {
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
          }
          .fc-button-primary:hover {
            background-color: #1e2b37 !important;
          }
          td.fc-widget-header:last-of-type, td.fc-widget-content:last-of-type {
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
          }
          td.fc-list-item-marker.fc-widget-content, td.fc-list-item-time.fc-widget-content, td.fc-list-item-title.fc-widget-content {
            border-bottom: 1px solid #ddd;
          }
          td.fc-list-item-time.fc-widget-content{
            border-right: 0px;
          }
          td.fc-list-item-title.fc-widget-content{
            border-left: 0px;
          }
          div.fc-view.fc-listMonth-view.fc-list-view.fc-widget-content{
            border-bottom: 0px;
          }
          a.fc-more {
            font-weight: bolder;
            background-color: #1a252f;
            color: #fff;
          }
          a.fc-event, tr.fc-list-item{
              cursor: pointer;
          }
          ";
        $view = $this->getView();
        $view->registerJs($script, View::POS_HEAD, $id);
        $view->registerCss($css);
    }
}