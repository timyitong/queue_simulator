Virtual Queue Simulator
===============

Simulate a job fair queueing situation

An example for the API interface is as follows:
<pre><code>
	var url="http://127.0.0.1:8080/simulate/";
	$.ajax({
	    url: url,
	    type: 'POST',
	    data:{	json_data: JSON.stringify({
	    			student_num: 4,
	    			company_num: 3,
	    			companies:[
	    				{weight:10,speed:2},
	    				{weight:11,speed:1},
	    				{weight:9,speed:2}
	    			],
	    			students:"",
	    		}),
	    		csrfmiddlewaretoken:'{{csrf_token}}'
	    	},
	    success: function(data, textStatus, xhr) {
	    	var text=xhr.responseText
	    	console.log(text)
	    }
	});
</code></pre>

Returns:
<pre><code>
{"json_data": "[{\"cid\": 0, \"type\": \"enqueue\", \"time\": 1, \"sid\": 0}, 
		{\"cid\": 0, \"type\": \"enqueue\", \"time\": 1, \"sid\": 1}, 
		{\"cid\": 1, \"type\": \"enqueue\", \"time\": 1, \"sid\": 2}, 
		{\"cid\": 1, \"type\": \"enqueue\", \"time\": 1, \"sid\": 3}, 
		{\"cid\": 0, \"type\": \"dequeue\", \"time\": 2, \"sid\": 0}, 
		{\"cid\": 1, \"type\": \"dequeue\", \"time\": 2, \"sid\": 2}, 
		{\"cid\": 1, \"type\": \"dequeue\", \"time\": 3, \"sid\": 3}, 
		{\"cid\": 2, \"type\": \"enqueue\", \"time\": 3, \"sid\": 0}, 
		{\"cid\": 0, \"type\": \"enqueue\", \"time\": 3, \"sid\": 2}, 
		{\"cid\": 0, \"type\": \"dequeue\", \"time\": 4, \"sid\": 1}, 
		{\"cid\": 2, \"type\": \"dequeue\", \"time\": 4, \"sid\": 0}, 
		{\"cid\": 0, \"type\": \"enqueue\", \"time\": 4, \"sid\": 3}, 
		{\"cid\": 1, \"type\": \"enqueue\", \"time\": 5, \"sid\": 1}, 
		{\"cid\": 1, \"type\": \"enqueue\", \"time\": 5, \"sid\": 0}, 
		{\"cid\": 0, \"type\": \"dequeue\", \"time\": 6, \"sid\": 2}, 
		{\"cid\": 1, \"type\": \"dequeue\", \"time\": 6, \"sid\": 1}, 
		{\"cid\": 1, \"type\": \"dequeue\", \"time\": 7, \"sid\": 0}, 
		{\"cid\": 2, \"type\": \"enqueue\", \"time\": 7, \"sid\": 2}, 
		{\"cid\": 2, \"type\": \"enqueue\", \"time\": 7, \"sid\": 1}, 
		{\"cid\": 0, \"type\": \"dequeue\", \"time\": 8, \"sid\": 3}, 
		{\"cid\": 2, \"type\": \"dequeue\", \"time\": 8, \"sid\": 2}, 
		{\"cid\": 2, \"type\": \"enqueue\", \"time\": 9, \"sid\": 3}, 
		{\"cid\": 2, \"type\": \"dequeue\", \"time\": 10, \"sid\": 1}, 
		{\"cid\": 2, \"type\": \"dequeue\", \"time\": 12, \"sid\": 3}]"
} 
</code></pre>
