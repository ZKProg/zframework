<?php 

namespace Framework;

class ConfigXMLParser {

    protected $_dom_document = NULL;

    public function __construct($config_file) {

        $this->_dom_document = new \DOMDocument('1.0', 'utf-8');

        if (!$this->_dom_document->load($config_file)) {
            // TODO Log the error + action
            die('XML Config parser error');
        }

    }

    /**
     * Returns the NodeList for a given string.
     * Return False if none is found.
     *
     * @param string $tag
     * @return mixed
     */
    public function getTagNodesList($tag) {  

        return $this->_dom_document->getElementsByTagName((string)$tag);

    }

    /**
     * Returns the FIRST value of a given $tag and attribute combination.
     * Returns False if the attribute is not found.
     *
     * @param \DOMNode $node
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
     * @param \DOMNode $node
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