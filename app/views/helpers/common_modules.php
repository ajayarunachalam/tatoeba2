<?php
/**
 * Tatoeba Project, free collaborative creation of multilingual corpuses project
 * Copyright (C) 2010  Allan SIMON <allan.simon@supinfo.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Tatoeba
 * @author   Allan SIMON <allan.simon@supinfo.com>
 * @license  Affero General Public License
 * @link     http://tatoeba.org
 */


/**
 * Helper for modules and part of module
 *
 * @category Utilities
 * @package  Helpers
 * @author   SIMON Allan <allan.simon@supinfo.com>
 * @license  Affero General Public License
 * @link     http://tatoeba.org
 */

class CommonModulesHelper extends AppHelper
{

    public $helpers = array(
        'Languages',
        'Form',
        'Html',
    );

    /**
     * create a module where one can filter the page by lang
     *
     * @param int $maxNumberOfParams The numbers of params use in the controller
     *                               to generate the view where you include this
     *                               NOTE: the lang must be the last params
     *
     * @return void
     */
    public function createFilterByLangMod($maxNumberOfParams = 1)
    {
        ?>
        <div class="module">
            <h2><?php __('Filter by language'); ?></h2>
            <?php
            /*to stay on the same page except language filter option*/
            // we reconstruct the path
            $path ='/';
            // language of the interface
            if (!empty($this->params['lang'])) {
                $path .= $this->params['lang'] .'/';
            }

            $path .= $this->params['controller'].'/';
            if ($this->params['action'] != 'display') {
                $path .= $this->params['action'].'/';
            }

            $params = $this->params['pass'];

            $numberOfParams = count($params);

            $paramsWitoutLang = $numberOfParams;
            if ($numberOfParams === $maxNumberOfParams) {
                $paramsWitoutLang--;            
            }

            for ($i = 0; $i < $paramsWitoutLang; $i++) {
                $path .= $params[$i] .'/'; 
            } 
            
            $lang = 'und' ;
            if (isset($params[$maxNumberOfParams-1])) {
                $lang  = $params[$maxNumberOfParams-1]; 
            }

            $langs = $this->Languages->languagesArray();

            echo $this->Form->select(
                'filterLanguageSelect',
                $langs,
                $lang,
                array(
                    "onchange" => "
                        if (this.value == 'und') {
                            $(location).attr('href','$path');
                        } else { 
                            $(location).attr('href','$path' + this.value);
                        }" 
                    // the if is to avoid a duplicate page (with and without "und")
                ),
                false
            );
            ?> 
        </div>
    <?php 
    }
    
    /**
     * Display a module content which indicate the user does not exist
     * 
     * @param string $userName The username which doesn't exist.
     * @param string $backLink The backlink.
     *
     * @return void
     */
    public function displayNoSuchUser($userName, $backLink)
    {
        echo '<h2>';
        echo sprintf(
            __("There's no user called %s", true),
            $userName
        );
        echo '</h2>';

        echo $this->Html->link(__('Go back to previous page', true), $backLink);   
    }
}
?>