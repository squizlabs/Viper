<?php

require_once 'AbstractViperUnitTest.php';

/**
 * An abstract class that all the CustomClassStyle unit tests should extend.
 */
abstract class AbstractViperCustomClassStylesUnitTest extends AbstractViperUnitTest
{
    /**
     * Set custom class styles.
     *
     * @return array
     */
    protected function setCustomClassStyles()
    {
        $this->setPluginSettings(
            'ViperFormatPlugin',
            array(
             'styles' => array(
                          'Simple Image Border' => array(
                                                    'showFor'    => 'img,h1',
                                                    'hideFor'    => '*',
                                                    'classNames' => 'simple-image-border',
                                                   ),
                          'Article'             => array(
                                                    'classNames' => 'article',
                                                    'showFor'    => 'p',
                                                   ),
                          'Multi Columns'       => array(
                                                    'classNames' => 'multi-col',
                                                    'hideFor'    => 'text-selection,img',
                                                   ),
                          'Caption'             => 'simple-image-border image-caption',
                          'Round Image'         => 'round-image',
                          'Ordered List'        => 'ordered-list',
                         ),
            )
        );

    }//end setCustomClassStyles()


    /**
     * Returns the selected styles.
     *
     * @return array
     */
    protected function getSelectedStyles()
    {
        return $this->sikuli->execJS('viper.ViperTools.getItem(\'ViperFormatPlugin-classList\').getSelectedItems()');

    }//end getSelectedStyles()


    /**
     * Selects the specified styles.
     *
     * @param array $styles Array of class names separated by spaces.
     *
     * @return void
     */
    protected function selectStyles(array $styles)
    {
        $rect = $this->getBoundingRectangle('.ViperUtil-visible[data-id="test-ViperFormatPlugin-classPopout"]');
        if (empty($rect) === true) {
            $this->sikuli->clickVisibleElement('.ViperFormatPlugin-stylePickerButton', 0, true);
        }

        foreach ($styles as $classNames) {
            $this->sikuli->clickVisibleElement('li[data-id="'.$classNames.'"]');
        }

    }//end selectStyles()


    /**
     * Removes the specified styles.
     *
     * @param array $styles Array of class names separated by spaces.
     *
     * @return void
     */
    protected function removeStyles(array $styles)
    {
        foreach ($styles as $classNames) {
            $this->sikuli->clickVisibleElement('.Viper-visible .ViperFormatPlugin-styleListItem-remove[data-id="'.$classNames.'"]');
        }

    }//end removeStyles()

}//end class