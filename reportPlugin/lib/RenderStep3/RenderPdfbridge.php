<?php

/*
 * This file is part of the reportPlugin package.
 * (c) 2011-2012 Juan Manuel Fernandez <juanmf@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This class uses JavaBridge to invoke ApacheFop's services.
 * 
 * You can determine the usage of this class in global config, as you might want 
 * to consume ApacheFop with a different strategy.
 * 
 * @author Juan Manuel Fernandez <juanmf@gmail.com>
 * @see    %sf_plugins_dir%/reportPlugin/config/sfExportGlobals.yml
 * @see    Renderer
 */
class RenderPdfBridge extends Renderer
{
    private $_pdfRenderer = null;
    
    /**
     * This is the final Step in this 3 steps process:
     * <ol> 
     * <li>Step 1 consists in generating the XML bsaed raw data for the report. </li>
     * <li>Step 2 consists in merging this raw data with a XSL-FO template to give it
     * the presentation information. XSL-FO acts as an intermediate language used 
     * to render the final repor in any format with a last transformation. </li>
     * <li>Step 3 consists on rendering the XSL-FO representtion (the intermediate 
     * language) of the report to the PDF output fromat.</li>
     * <ol>
     * 
     * @param DOMDocument   $xslFo    The XSL-FO representation of the processed 
     * report, as we get it just after step 2 in this 3 steps process.
     * @param sfWebResponse $response The Response Object, should be passed all 
     * the way down from the action. So we can change some headers', ContentType
     * to 'application/pdf'.
     * 
     * @see %sf_plugins_dir%/reportPlugin/config/sfExportGlobals.yml
     * @return String With the rendered report content. PDF Binary stream returned
     * by ApacheFop.
     */
    public function renderReport(DOMDocument $xslFo, sfWebResponse $response = null) 
    {
        $response->setContentType('application/pdf');
        $this->_pdfRenderer = new RenderPDFConsummer($xslFo->saveXML());
        /*TODO: implement javaBridge*/
        return $this->_pdfRenderer->getPdfStream();
    }
}
