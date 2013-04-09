<?php
/**
 * HtmlText Helper
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 * */

namespace View\Helper;

/**
 * HtmlText Helper
 *
 * Geef HTML als plain text weer.
 *
 * Gebasseerd op code van Jevon Wright
 * http://journals.jevon.org/users/jevon-phd/entry/19818
 * Copyright (c) 2010 Jevon Wright and others
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 * */
class HtmlText extends \Helper 
{

    /**
     * Zet HTML om in Plain Text
     * 
     * @param string $html HTML
     * 
     * @return string Plain Text
     */
    public function text($html) {
        
        $html = $this->fix_newlines($html);

        if (empty($html)) {
            return '';
        }
        
        try {
            $doc = new \DOMDocument();
            if (!$doc->loadHTML($html)) {
                throw new \Exception(__f('Fout bij laden HTML', 'exception'));
            }
        } catch(\Exception $e) {
            // Failback
            $html = strip_tags($html);
            $html = html_entity_decode($html, ENT_QUOTES, "ISO-8859-1");
            $html = preg_replace('/&#(\d+);/me',"chr(\\1)",$html); 
            $html = preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)",$html); 
            $html = utf8_encode($html);
            return $html;
        }

        $output = $this->iterate_over_node($doc);
        $output = preg_replace("/[ \t]*\n[ \t]*/im", "\n", $output);
        $output = trim($output);
        $output = utf8_decode($output);
        
        return $output;
    }
    
    private function fix_newlines($text) {
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);
        return $text;
    }

    private function next_child_name($node) {
        $nextNode = $node->nextSibling;
        while ($nextNode !== null) {
            if ($nextNode instanceof \DOMElement) {
                break;
            }
            $nextNode = $nextNode->nextSibling;
        }
        $nextName = null;
        if ($nextNode instanceof \DOMElement AND $nextNode !== null) {
            $nextName = strtolower($nextNode->nodeName);
        }

        return $nextName;
    }

    function prev_child_name($node) {
        // get the previous child
        $nextNode = $node->previousSibling;
        while ($nextNode !== null) {
            if ($nextNode instanceof \DOMElement) {
                break;
            }
            $nextNode = $nextNode->previousSibling;
        }
        $nextName = null;
        if ($nextNode instanceof \DOMElement AND $nextNode !== null) {
            $nextName = strtolower($nextNode->nodeName);
        }

        return $nextName;
    }

    function iterate_over_node($node) {        

        if ($node instanceof \DOMText) {
            return preg_replace("/\\s+/im", " ", $node->wholeText);
        } else if ($node instanceof \DOMDocumentType) {
            return "";
        }

        $nextName = $this->next_child_name($node);

        $name = strtolower($node->nodeName);

        // start whitespace
        switch ($name) {
            case "hr":
                return "\n";

            case "style":
            case "head":
            case "title":
            case "meta":
            case "script":
                // ignore these tags
                return "";

            case "h1":
            case "h2":
            case "h3":
            case "h4":
            case "h5":
            case "h6":
                $output = "\n";
                break;

            case "p":
            case "div":
                $output = "\n";
                break;

            default:
                $output = "";
                break;
        }

        for ($i = 0; $i < $node->childNodes->length; $i++) {
            $n = $node->childNodes->item($i);
            $text = $this->iterate_over_node($n);
            $output .= $text;
        }

        // end whitespace
        switch ($name) {
            case "style":
            case "head":
            case "title":
            case "meta":
            case "script":
                return "";

            case "h1":
            case "h2":
            case "h3":
            case "h4":
            case "h5":
            case "h6":
                $output .= "\n";
                break;

            case "p":
            case "br":
                // add one line
                if ($nextName != "div")
                    $output .= "\n";
                break;

            case "div":
                // add one line only if the next child isn't a div
                if ($nextName != "div" AND $nextName !== null)
                    $output .= "\n";
                break;

            default:
            // do nothing
        }

        return $output;
    }

}