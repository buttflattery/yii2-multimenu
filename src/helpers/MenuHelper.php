<?php
// @codingStandardsIgnoreStart
namespace buttflattery\multimenu\helpers;

use yii\helpers\Url;
use yii\base\Component;
use yii\base\InvalidArgumentException;

class MenuHelper extends Component
{
    // @codingStandardsIgnoreEnd

    /**
     * The model class to retrieve the menu items
     *
     * @var mixed
     */
    private $_model;
    /**
     * @var string
     */
    private $_labelField = 'label';
    /**
     * @var string
     */
    private $_linkField = 'link';

    /**
     * @var string
     */
    private $_parentIdField = 'parent_id';

    /**
     * @var string
     */
    private $_idField = 'id';

    /**
     * @var string|array
     */
    private $_orderField = 'order';

    /**
     * @var string
     */
    private $_orderByField;

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @param $model
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }

    /**
     * @return mixed
     */
    public function getLabelField()
    {
        return $this->_labelField;
    }

    /**
     * @param $fieldName
     */
    public function setLabelField($fieldName)
    {
        $this->_labelField = $fieldName;
    }

    /**
     * @return mixed
     */
    public function getLinkField()
    {
        return $this->_linkField;
    }

    /**
     * @param $fieldName
     */
    public function setLinkField($fieldName)
    {
        $this->_linkField = $fieldName;
    }

    /**
     * @return mixed
     */
    public function getParentIdField()
    {
        return $this->_parentIdField;
    }

    /**
     * @param $fieldName
     */
    public function setParentIdField($fieldName)
    {
        $this->_parentIdField = $fieldName;
    }

    /**
     * @return mixed
     */
    public function getIdField()
    {
        return $this->_idField;
    }

    /**
     * @param $fieldName
     */
    public function setIdField($fieldName)
    {
        $this->_idField = $fieldName;
    }

    /**
     * @return mixed
     */
    public function getOrderField()
    {
        return $this->_orderField;
    }

    /**
     * @param $fieldName
     */
    public function setOrderField($fieldName)
    {
        $this->_orderField = $fieldName;
    }

    /**
     * Initis the component
     *
     * @throws InvalidArgumentException
     * @return null
     */
    public function init()
    {
        if ($this->model === null) {
            throw new InvalidArgumentException("The model property must be set.");
        }
    }

    /**
     * Returns the menu items array
     *
     * @return mixed
     */
    public function getMenuItems($orderBy = null)
    {

        if (null !== $orderBy) {
            $this->_orderByField = $orderBy;

            //if array then implode string with column names
            if (is_array($orderBy)) {
                $this->_orderByField = implode(",", $orderBy);
            }
        }

        $items = [];
        $parentItems = self::getTopLevelItems();

        if (!empty($parentItems)) {
            $items = self::_buildItemsArray($parentItems);
        }

        return $items;
    }

    /**
     * Builds the menu items array for use
     *
     * @param array $items the top level items in the menu
     *
     * @return array
     */
    /**
     * @param $string
     * @return mixed
     */
    private function _buildItemsArray($items)
    {

        foreach ($items as $index => $parentLink) {
            $link = $this->getLinkField();
            $label = $this->getLabelField();
            $id = $this->getIdField();

            $isLink = ($parentLink->$link !== null && $parentLink->$link !== '' && $parentLink->$link !== '#.');
            $isActive = $isLink && (\Yii::$app->controller->id . '/' . \Yii::$app->controller->action->id == $parentLink->$link);

            $route = $this->_createRoute($parentLink->$link);

            $item[] = [
                "label" => $parentLink->$label,
            ];

            if ($parentLink->$link === null) {
                $item[sizeof($item) - 1]["label"] = "<span>" . $item[$index]["label"] . "</span>";
            } else {
                $item[sizeof($item) - 1] = array_merge(
                    $item[sizeof($item) - 1],
                    [
                        'url' => $isLink ? $route : 'javascript:void(0)',
                    ]
                );
            }

            //mark active item
            $isActive && $item[$index]['active'] = $isActive;

            $children = self::hasChild($parentLink->$id);
            $hasChild = !empty($children);

            if ($hasChild) {
                $item[$index]['items'] = self::_buildItemsArray($children);
            }
        }

        return $item;
    }
    
    /**
     * Creates the url using the \yii\helpers\Url separating the query string
     * from the url and providing it as an array to parse the urlMager routes
     * and create SEO friendly urls accordingly
     *
     * @param string $url the url for the menu link can be controller/action
     * or controller/action?var1=1&var2=something
     *
     * @return string
     */
    private function _createRoute($url)
    {
        //regex to match "http://","https://" or "?" in the url
        $re = '/^(http:\/\/|https:\/\/)|(\?)/';
        preg_match($re, $url, $matches);

        if (empty($matches)) { //is without query string url
            return [Url::to([$url])];
        } elseif ($matches[0] == 'https://' || $matches[0] == 'http://') { // is an external url

            return $url;
        } elseif ($matches[0] == '?') { // is a query string url
            $params = [];

            //extract the part of query string from the url like ?var=1&var=2
            $queryStringPart = strstr($url, $matches[0]);
            $params[] = strstr($url, $matches[0], true);

            //explode the query string variables
            $queryStringArray = explode(
                "&",
                substr($queryStringPart, 1, strlen($queryStringPart))
            );

            //iterate all the vars and create a params array
            foreach ($queryStringArray as $var) {
                $paramsPart = explode("=", $var);
                $params[$paramsPart[0]] = $paramsPart[1];
            }
            return [Url::to($params)];
        }

    }

    /**
     * Checks if the current menu item has a child
     *
     * @param integer $parent_id the parent menu item id
     *
     * @return array
     */
    public function hasChild($parent_id)
    {
        $model = $this->getModel();
        $order = $this->getOrderField();
        $orderBy = $this->_orderByField === null ? $order : $this->_orderByField;

        return $model::find()
            ->where(
                ['=', $this->getParentIdField(), $parent_id]
            )
            ->orderBy($orderBy)
            ->all();
    }

    /**
     * Returns the top level menu items only
     *
     * @return array
     */
    public function getTopLevelItems()
    {
        $model = $this->getModel();
        $order = $this->getOrderField();
        $orderBy = $this->_orderByField === null ? $order : $this->_orderByField;
        return $model::find()
            ->where(
                ['is', $this->getParentIdField(), null]
            )
            ->orderBy($orderBy)
            ->all();
    }

}
