<?php
// @codingStandardsIgnoreStart
namespace buttflattery\multimenu\helpers;

use yii\base\Component;
use yii\base\InvalidArgumentException;
use yii\helpers\Url;

class MenuHelper extends Component
{
    // @codingStandardsIgnoreEnd

    /**
     * The model class to retrieve the menu items
     *
     * @var mixed
     */
    public $model;

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
    public function getMenuItems()
    {
        $items = [];
        $parentItems = self::getTopLevelItems();
        $items = self::_buildItemsArray($parentItems);
        return $items;
    }

    /**
     * Builds the menu items array for use
     *
     * @param array $items the top level items in the menu
     *
     * @return array
     */
    private function _buildItemsArray($items)
    {

        foreach ($items as $index => $parentLink) {
            $isLink = ($parentLink->menu_link !== '' && $parentLink->menu_link !== '#.' && null !== $parentLink->menu_link);
            $isActive = $isLink && (\Yii::$app->controller->id . '/' . \Yii::$app->controller->action->id == $parentLink->menu_link);
            $route = $this->_createRoute($parentLink->menu_link);

            $item[] = [
                'label' => $parentLink->menu_name,
                'url' => $isLink ? $route : 'javascript:void(0)',
                'active' => $isActive
            ];
            $children = self::hasChild($parentLink->id);
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
     * @param string $url the url for the menu link can be controller/action or controller/action?var1=1&var2=something
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

            //extract the part of query string fro the url like ?var=1&var=2
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
        $model = $this->model;
        return $model::find()->where(['=', 'parent_id', $parent_id])->all();
    }

    /**
     * Returns the top level menu items only
     *
     * @return array
     */
    public function getTopLevelItems()
    {
        $model = $this->model;
        return $model::find()->where(['is', 'parent_id', null])->all();
    }

}
