<?php 

namespace Framework;

abstract class ConfigXMLParser {

    protected $_dom_document = NULL;

    public function __construct($config_file) {

        $this->_dom_document = new \DOMDocument('1.0', 'utf-8');

        if (!$this->_dom_document->load($config_file)) {
            // TODO Log the error + action
        }

    }

    /**
     * Returns the NodeList for a given string.
     * Return False if none is found.
     *
     * @param string $tag
     * @return mixed
     */
    protected function getTagNodeList($tag) {  

        return $this->_dom_document->getElementsByTagName((string)$tag);

    }

    /**
     * Returns the value of a given $tag and attribute combination.
     * Returns False if the attribute is not found.
     *
     * @param \DOMNode $node
     * @param string $attribute
     * @return mixed
     */
    protected function getNodeAttributeValue($tag, $attribute) {

        $nodes = $this->getTagNodeList($tag);

        foreach($nodes as $key => $node) {
            if ($node->hasAttribute($attribute)) return $node->getAttribute($attribute);
        }

        return false;

    }

    /**
     * Get the value of _dom_document
     */ 
    protected function get_dom_document()
    {
        return $this->_dom_document;
    }
}