<h1>Congratulations!</h1>

<p>You're now flying with Phalcon. Great things are about to happen!</p>

<hr>

{{link_to('index/testLink', 'Test a link')}}<br>

{{link_to('index/testGenUrl', 'Test gen url')}}<br>

{{link_to('index/testAssets', 'Test call assets')}}<br>

{{link_to('index/testRedirect', 'Test redirect to not found')}}<br>

{{link_to('index/testPagination', 'Test pagination')}}<br>

{{link_to('index/testSession', 'Test session')}}<br>

{{link_to('index/testCookie', 'Test cookie')}}<br>

{{link_to('index/testLog', 'Test logger')}}<br>

{{link_to('index/testCache', 'Test cache')}}<br>

<hr>

<h3>Test language translation</h3>
{{t._('index_welcome')}} {{t._('index_hello_X', ['name': 'Developer'])}}<br>
<br>
{{t._('core_credit')}}

<hr>

{{link_to('contact', 'Go to contact module')}}<br>
{{link_to('dbt', 'Go to database test')}}<br>

<p>This page use Volt template.</p>
