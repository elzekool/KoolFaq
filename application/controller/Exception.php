<?php
/**
 * Exception Controller
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

namespace Controller;

/**
 * Exception Controller
 * 
 * Wordt in de Bootstrapper ingesteld voor de afhandeling van Excepties
 * Niet door de gebruiker benaderbaar
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/
class Exception extends \Controller
{
 
    /**
     * Handel normale fout af
     * 
     * @param \Exception $e Exception
     * 
     * @return void
     */
    public function handle(\Exception $e) {
        header("HTTP/1.0 500 Server Error", 500);
        echo '<!DOCTYPE html PUBLIC>' . "\n";
        echo '<html>';
        echo '<head><title>' . _h($e->getMessage()) . '</title></head>';
        echo '<body style="background: #500;">';			
        echo '<div style="font-family: arial; color: #333; font-size: 14px; margin: 50px auto; width: 600px; background: #fff; padding: 50px; border-radius: 5px;">';
        echo '<h1 style="margin: 10px 0 0 0;">Oeps, er is iets misgegaan</h1>';
        echo '<h3 style="margin: 5px 0 0 0; color: #777; ">' . _h($e->getMessage()) . ' <span style="font-size: 0.5em;">' . _h(get_class($e)) . '</span></h3>';
        echo '<p>';
            echo 'Er is een fout opgetreden tijdens het verwerken van het verzoek.<br />';
            echo 'Probeer het over enkele ogenblikken nogmaals.';
        echo '</p>';
        
        if (\KoolDevelop\Configuration::getInstance('core')->get('errors.display_stacktrace', 1) == 1) {
            echo '<div style="font-family: monospace; font-size: 12px; background: #eee; padding: 1em; width: 90%; border: 1px dashed #999; margin: 0 0 2em 0;">';
            echo '<b>Stack trace:</b>';
            echo '<ol>';
            foreach ($e->getTrace() as $trace_no => $trace_item) {
                echo '<li>';
                if (isset($trace_item['file'])) {
                    echo strlen($trace_item['file']) < 30 ? $trace_item['file'] : '...' . substr($trace_item['file'], -30);
                    echo ':';
                    echo $trace_item['line'];
                } else {
                    echo strlen($e->getFile()) < 30 ? $e->getFile() : '...' . substr($e->getFile(), -30);
                    echo ': ';
                    echo $e->getLine();
                }
                echo ' ';
                echo isset($trace_item['class']) ? $trace_item['class'] . ':' . $trace_item['function'] : $trace_item['function'] . '()';
                echo "</li>";
            }
            echo '</ol>';
            echo '</div>';
        }

        if (\KoolDevelop\Configuration::getInstance('core')->get('errors.display_details', 1) == 1) {
            if ($e instanceof \KoolDevelop\Exception\Exception) {
                echo '<div style="font-family: monospace; font-size: 12px; background: #eee; padding: 1em; width: 90%; border: 1px dashed #999; margin: 0 0 2em 0;">';
                    echo '<b>Details:</b><br />';
                    echo nl2br($e->getDetail());
                echo '</div>';
            }
        }

        echo '</div>';
        

        echo '</body>';
        echo '</html>';
        die();
    }
    
    
    /**
     * Handel object niet gevonden fout af
     * 
     * @param \Exception $e Exception
     * 
     * @return void
     */
    public function notfound(\KoolDevelop\Exception\NotFoundException $e) {
        header("HTTP/1.0 404 Not Found", 404);
        echo '<!DOCTYPE html PUBLIC>' . "\n";
        echo '<html>';
        echo '<head><title>' . _h($e->getMessage()) . '</title></head>';
        echo '<body style="background: #013E77;">';			
        echo '<div style="font-family: arial; color: #333; font-size: 14px; margin: 50px auto; width: 600px; background: #fff; padding: 50px; border-radius: 5px;">';
        echo '<h1 style="margin: 10px 0 0 0;">Oeps, er is iets misgegaan</h1>';
        echo '<h3 style="margin: 5px 0 0 0; color: #777; ">' . _h($e->getMessage()) . '</h3>';
        echo '<p>';
            echo 'Er is een fout opgetreden tijdens het verwerken van het verzoek.<br />';
            echo 'De opgegeven locatie is niet gevonden. Probeer het over enkele ogenblikken nogmaals.';
            echo 'Of ga terug naar de <a href="/">startpagina</a>.';
        echo '</p>';

        if (\KoolDevelop\Configuration::getInstance('core')->get('errors.display_stacktrace', 1) == 1) {
            echo '<div style="font-family: monospace; font-size: 12px; background: #eee; padding: 1em; width: 90%; border: 1px dashed #999; margin: 0 0 2em 0;">';
            echo '<b>Stack trace:</b>';
            echo '<ol>';
            foreach ($e->getTrace() as $trace_no => $trace_item) {
                echo '<li>';
                if (isset($trace_item['file'])) {
                    echo strlen($trace_item['file']) < 30 ? $trace_item['file'] : '...' . substr($trace_item['file'], -30);
                    echo ':';
                    echo $trace_item['line'];
                } else {
                    echo strlen($e->getFile()) < 30 ? $e->getFile() : '...' . substr($e->getFile(), -30);
                    echo ': ';
                    echo $e->getLine();
                }
                echo ' ';
                echo isset($trace_item['class']) ? $trace_item['class'] . ':' . $trace_item['function'] : $trace_item['function'] . '()';
                echo "</li>";
            }
            echo '</ol>';
            echo '</div>';
        }
        
        echo '</div>';
       
        
        echo '</body>';
        echo '</html>';
        die();
    }
    
}