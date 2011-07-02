var baseUri;
function makeJsonRpcCall(group, method, params, callback) {
    var payload = {
        "jsonrpc":"2.0",
        "method":method,
        "params":params
    };
    $.post(baseUri+'webservice/shopws/jsonrpc/'+group,
            {'jsonrpc':JSON.stringify(payload)},
            function(data) {
                callback(data);
            },
            'json');
}

var handleLanguages = function(data) {
    if (data.error != null) {
        alert(data.error.code+": "+data.error.message);
    } else {
        $(data.result).each(function (index, item) {
            alert(item.id+"|"+item.name);
        });
    }
}

function getLanguages() {
    makeJsonRpcCall("", "get_languages", null, handleLanguages);
}