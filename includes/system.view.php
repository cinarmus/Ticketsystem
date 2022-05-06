<?php

/**
 * Die Klasse hält ein Array mit allen anzuzeigenden Views sowie den zugehörigen Skript-Pfaden. Alle im Controller geladenen Models sollten
 * zur Laufzeit dem Viewobjekt übergeben werden. Gerendert wird die View üblicherweise in der index.php.
 */

Class View{
    /**
     *
     * @var Array Assoziativ Name der view (z.B. view1) und anschließend der Pfad der aufzurufenden Datei. Diese werden üblicherweise im Controller festgelegt
     */
    Public $path=array();
    Public $viewport=array();
    Public $class=array();
    Public $dataScheme=array();
    /**
     * Ruft die gewünschte View (<i>require</i>)auf und zeigt sie an dieser Stelle an. 
     * @param String $view Name der View, die gerendert werden soll
     */
    Public  function render($view="view1"){
        if ($this->path[$view]!=""){
            Core::$currentView=$view;
            Core::$currentViewport=$this->viewport[$view]; // legt aktuellen Viewport 
            require($this->path[$view]);
        }
    }
 
}