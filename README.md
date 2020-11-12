# Mobiledoc parser

Mobiledoc is a publishing solution for authoring, saving and rendering rich WYSIWYG content. Read more about it [here](https://github.com/bustle/mobiledoc-kit).

This library parses such content and converts it into HTML. It's something that I wrote as part of a POC, but haven't had much use for since.

## Custom cards
If we were to add support for adding carousels into our document, we'd go about it like this:

The card section in our mobildoc document:
```json
"cards": [
        [
            "carousel",
            [
                {
                    "caption": "Very nice",
                    "src": "https://images.unsplash.com/photo-1492145080082-3154cd0d402a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1650&q=80"
                },
                {
                    "caption": "Awesomesauce.",
                    "src": "https://images.unsplash.com/photo-1547512998-31edce8d3755?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1653&q=80"
                },
                {
                    "caption": "Such zen.",
                    "src": "https://images.unsplash.com/photo-1439405326854-014607f694d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1650&q=80"
                }
            ]
        ]
    ],
```

Our card renderer:
```php
class CarouselCardRenderer implements CardRendererInterface
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(Card $card): string
    {
        return $this->twig->render('cards/carousel.html.twig', [
            'slides' => $card->getPayload(),
        ]);
    }

    public function supports(string $cardName, string $format): bool
    {
        return 'carousel' === $cardName && 'html' === $format;
    }
}
```

The twig template:
```twig
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        {% for slide in slides %}
            <li data-target="#carouselExampleIndicators" data-slide-to="{{ loop.index }}" class="{{ loop.index == 1 ? 'active' : ''  }}"></li>
        {% endfor %}
    </ol>
    <div class="carousel-inner">
        {% for slide in slides %}
        <div class="carousel-item {{ loop.index == 1 ? 'active' : ''  }}">
            <img class="d-block w-100" src="{{ slide.src }}" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>{{  slide.caption }}</h5>
            </div>
        </div>
        {% endfor %}
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
```

Initialize our HTML renderer:
```php
$carouselCardRenderer = new CarouselCardRenderer($twig);
$renderer = new HtmlRenderer([$carouselCardRenderer]);
...
$html = $document->render($renderer); 
```

## Custom renderer
> ❕ TODO: Document custom renderers