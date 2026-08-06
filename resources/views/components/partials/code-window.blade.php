<div class="code-window-stage">
    <div class="code-window-layers">
        <x-partials.datacenter-mini/>

        <div class="code-window">
            <div class="code-window-bar">
                <span class="code-window-dot"></span>
                <span class="code-window-dot"></span>
                <span class="code-window-dot"></span>
                <span class="code-window-title">YourProject.php</span>
            </div>
            <pre class="code-window-body"><code><span class="ck">class</span> <span class="cn">YourProject</span> <span class="ck">extends</span> <span class="cn">Model</span>
{
    <span class="ck">public function</span> <span class="cf">updates</span>(): <span class="cn">HasMany</span>
    {
        <span class="ck">return</span> <span class="cv">$this</span>-&gt;<span class="cf">hasMany</span>(<span class="cn">ProjectUpdate</span>::<span class="cf">class</span>)
            -&gt;<span class="cf">latest</span>();
    }
}</code></pre>
        </div>
    </div>
</div>
