<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace TwitterWidgetBundle\Extension;

use TwitterWidgets\Assets\OneTimeJsProvider;
use TwitterWidgets\Options\WidgetOptions;
use TwitterWidgets\Timeline\TimelineBuilderInterface;

class TimelineWidget extends \Twig_Extension
{
    protected $widgetOptions;
    protected $timeline;

    /**
     * @param WidgetOptions            $widgetOptions
     * @param TimelineBuilderInterface $timeline
     */
    public function __construct(WidgetOptions $widgetOptions, TimelineBuilderInterface $timeline)
    {
        $this->widgetOptions = $widgetOptions;
        $this->timeline      = $timeline;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('tw', [$this, 'renderWidget'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('twJs', [$this, 'getOneTimeWidgetJs'], ['is_safe' => ['html']]),

        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'timelinewidgetextensions';
    }

    /**
     * @param  array $options
     * @param  bool  $addJs
     * @return string
     */
    public function renderWidget($options, $addJs = true)
    {
        $this->widgetOptions->setFromArray($options);

        return $this->timeline->renderWidget($addJs);
    }

    /**
     * @return mixed
     */
    public function getOneTimeWidgetJs()
    {
        return (new OneTimeJsProvider())->getOneTimeWidgetJs();
    }
}
