<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace TwitterWidgetBundleTests\Extension;

use TwitterWidgetBundle\Extension\TimelineWidget;
use TwitterWidgets\Options\WidgetOptions;
use TwitterWidgets\Timeline\TimelineBuilder;

class TimelineWidgetTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $widgetOptions   = $this->getMock(WidgetOptions::class);
        $timelineBuilder = $this->getMock(
            TimelineBuilder::class,
            [],
            [$widgetOptions]
        );

        $this->assertInstanceOf(TimelineWidget::class, new TimelineWidget($widgetOptions, $timelineBuilder));
    }

    public function testTwoFunctionsAreRegistered()
    {
        $widgetOptions   = $this->getMock(WidgetOptions::class);
        $timelineBuilder = $this->getMock(
            TimelineBuilder::class,
            [],
            [$widgetOptions]
        );

        $extension = new TimelineWidget($widgetOptions, $timelineBuilder);

        $this->assertCount(2, $extension->getFunctions());
    }

    public function testName()
    {
        $widgetOptions   = $this->getMock(WidgetOptions::class);
        $timelineBuilder = $this->getMock(
            TimelineBuilder::class,
            [],
            [$widgetOptions]
        );

        $extension = new TimelineWidget($widgetOptions, $timelineBuilder);

        $this->assertEquals('timelinewidgetextensions', $extension->getName());
    }

    public function testOneTimeJs()
    {
        $widgetOptions   = $this->getMock(WidgetOptions::class);
        $timelineBuilder = $this->getMock(
            TimelineBuilder::class,
            [],
            [$widgetOptions]
        );

        $extension = new TimelineWidget($widgetOptions, $timelineBuilder);

        $this->assertGreaterThan(0, strpos($extension->getOneTimeWidgetJs(), 'widgets.js'));
    }


    public function testRenderWidget()
    {
        $widgetOptions = $this->getMock(WidgetOptions::class);

        $timelinebuilder = $this
            ->getMockBuilder(TimelineBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $timelinebuilder->expects($this->any())
            ->method('renderWidget')
            ->will($this->returnValue('rendered!'));

        $extension = new TimelineWidget($widgetOptions, $timelinebuilder);

        $this->assertEquals('rendered!', $extension->renderWidget([]));
    }
}
