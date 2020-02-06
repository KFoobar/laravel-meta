<?php

namespace KFoobar\LaravelMeta;

use Exception;
use Illuminate\Support\Str;

class TagContructor
{
    /**
     * Constructs the HTML tag.
     *
     * @param  string    $key
     * @param  string    $value
     * @throws Exception
     *
     * @return string
     */
    public function getTag(string $key, string $value)
    {
        $method = Str::camel(sprintf('get_%s_tag', $key));

        if (!method_exists($this, $method)) {
            throw new Exception('Tag not supported', 500);
        }

        $data = $this->{$method}($key, $value);

        return $this->construct($data['pattern'], $data['values']);
    }

    /**
     * Gets the csrf token tag pattern.
     *
     * @param string $key
     * @param string $value
     *
     * @return array
     */
    private function getCsrfTokenTag(string $key, string $value)
    {
        return [
            'pattern' => '<meta %s>',
            'values' => [
                'name' => $key,
                'content' => $value
            ],
        ];
    }

    /**
     * Gets the canonical tag pattern.
     *
     * @param string $key
     * @param string $value
     *
     * @return array
     */
    private function getCanonicalTag(string $key, string $value)
    {
        return [
            'pattern' => '<link rel="canonical" href="%s">',
            'values' => $value,
        ];
    }

    /**
     * Gets the charset tag pattern.
     *
     * @param string $key
     * @param string $value
     *
     * @return array
     */
    private function getCharsetTag(string $key, string $value)
    {
        return [
            'pattern' => '<meta charset="%s">',
            'values' => $value,
        ];
    }

    /**
     * Gets the content type tag pattern.
     *
     * @param string $key
     * @param string $value
     *
     * @return array
     */
    private function getContentTypeTag(string $key, string $value)
    {
        return [
            'pattern' => '<meta %s>',
            'values' => [
                'http-equiv' => $key,
                'content' => $value
            ],
        ];
    }

    /**
     * Gets the title tag pattern.
     *
     * @param string $key
     * @param string $value
     *
     * @return array
     */
    private function getTitleTag(string $key, string $value)
    {
        return [
            'pattern' => '<title>%s</title>',
            'values' => $value,
        ];
    }

    /**
     * Gets the refresh tag pattern.
     *
     * @param string $key
     * @param string $value
     *
     * @return array
     */
    private function getRefreshTag(string $key, string $value)
    {
        return [
            'pattern' => '<meta %s>',
            'values' => [
                'http-equiv' => $key,
                'content' => $value
            ]
        ];
    }

    /**
     * Gets the meta tag pattern.
     *
     * @param string $key
     * @param string $value
     *
     * @return array
     */
    private function getMetaTag(string $key, string $value)
    {
        return [
            'pattern' => '<meta %s>',
            'values' => [
                'name' => $key,
                'content' => $value
            ]
        ];
    }

    /**
     * Generates HTML tag from pattern.
     *
     * @param string $pattern
     * @param array  $data
     *
     * @return string
     */
    private function construct(string $pattern, $data)
    {
        if (is_array($data)) {
            $data = array_map(function ($key, $value) {
                return sprintf('%s="%s"', $key, $value);
            }, array_keys($data), $data);
        } else {
            $data = [$data];
        }

        return sprintf($pattern, implode(' ', $data)) . "\n";
    }
}
