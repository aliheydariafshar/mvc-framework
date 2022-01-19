<?php


namespace System\Database\Traits;


trait HasAttributes
{
    private function registerAttribute($object, string $attribute, $value)
    {
        $object->{$attribute} = $this->inCastsAttributes($attribute) ? $this->castDecodeValue($attribute, $value) : $value;
    }

    protected function arrayToAttributes(array $array, $object = null)
    {
        if (!$object) {
            $className = get_called_class();
            $object = new $className;
        }
        foreach ($array as $attribute => $value) {
            if ($this->inHiddenAttributes($attribute)) {
                continue;
            }

            $this->registerAttribute($object, $attribute, $value);
        }
        return $object;
    }

    protected function arrayToObjects(array $array)
    {
        $collection = [];
        foreach ($array as $value) {
            $object = $this->arrayToAttributes($value);
            array_push($collection, $object);
        }
        $this->collection = $collection;
    }

    private function inHiddenAttributes($attribute)
    {
        return in_array($attribute, $this->hidden);
    }

    private function inCastsAttributes($attribute)
    {
        return in_array($attribute, array_keys($this->casts));
    }

    private function castEncodeValue($attribute, $value)
    {
        if (in_array($this->casts[$attribute], ['array', 'object'])) {
            return serialize($value);
        }
        return $value;
    }

    private function castDecodeValue($attribute, $value)
    {
        if (in_array($this->casts[$attribute], ['array', 'object'])) {
            return unserialize($value);
        }
        return $value;
    }

    private function arrayToCastEncodeValue($values)
    {
        $newArray = [];
        foreach ($values as $attribute => $value) {
            $newArray[$attribute] = $this->inCastsAttributes($attribute) ? $this->castEncodeValue($attribute, $value) : $value;
        }
        return $newArray;
    }
}