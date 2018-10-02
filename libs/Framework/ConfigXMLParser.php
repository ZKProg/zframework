<?php 
/**
 * Author: Karim Zerf
 * License: MIT.
 */

namespace Framework;

/**
 * The ConfigXMLParser class is a helper class, that opens XML files, and provides for a set of utility methods, specific to the needs of the framework.
 */
class ConfigXMLParser {

    protected $_dom_document = NULL;

    public function __construct($config_file) {

        $this->_dom_document = new \DOMDocument('1.0', 'utf-8');

        // TODO: Create a more robust path pattern
        if (!$this->_dom_document->load(__DIR__ . '/../../' . $config_file)) {
            // TODO: Log the error + action
            die('XML Config parser error');
        }

    }

    /**
     * Returns the NodeList for a given string tag.
     * Return False if none is found.
     *
     * @param string $tag
     * @return mixed
     */
    public function getTagNodesList($tag) {  

        return $this->_dom_document->getElementsByTagName((string)$tag);

    }

    /**
     * Returns the *FIRST* value of a given $tag and attribute combination.
     * Returns False if the attribute is not found.
     *
     * @param string $tag
     * @param string $attribute
     * @return mixed
     */
    public function getNodeAttributeValue($tag, $attribute) {

        $nodes = $this->getTagNodesList($tag);

        foreach($nodes as $key => $node) {
            if ($node->hasAttribute($attribute)) return $node->getAttribute($attribute);
        }

        return false;

    }

    /**
     * Returns ALL the values of a given $tag and attribute combination.
     * Returns False no attribute is found.
     *
     * @param string $tag
     * @param string $attribute
     * @return mixed
     */
    public function getNodeAttributeValues($tag, $attribute) {

        $nodes = $this->getTagNodesList($tag);
        $values = [];

        foreach($nodes as $key => $node) {
            if ($node->hasAttribute($attribute)) \array_push($values, $node->getAttribute($attribute));
        }

        return empty($values) ? false : $values;

    }

    /**
     * Returns the DOMDocument, for classes needing just that.
     * 
     * @return \DOMDocument
     */ 
    public function get_dom_document()
    {
        return $this->_dom_document;
    }
}