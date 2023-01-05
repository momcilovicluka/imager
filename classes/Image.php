<?php

class Image
{
    private $title;
    private $username;
    private $image;

    function __construct($title, $username, $image)
    {
        $this->title = $title;
        $this->username = $username;
        $this->image = $image;
    }

    function getTitle()
    {
        return $this->title;
    }

    function getUsername()
    {
        return $this->username;
    }

    function getImage()
    {
        return $this->image;
    }

    function getHtml()
    {
        return "
            <div class=\"box\" onclick=\"window.open('{$this->image}')\">
                <div class=\"imgBx\">
                    <img src=\"{$this->image}\">
                </div>
                <div class=\"content\">
                    <div>
                        <h2>{$this->title}</h2>
                        <p>{$this->username}</p>
                    </div>
                </div>
            </div>";
    }
}
