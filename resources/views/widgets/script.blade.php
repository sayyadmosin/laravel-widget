(function(window) {
    'use strict';
    
    window.LaravelWidget = {
        init: function(targetId, config) {
            this.target = document.getElementById(targetId);
            this.config = config || {};
            this.apiUrl = config.apiUrl || 'http://127.0.0.1:8000/widget';
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.loadWidget());
            } else {
                this.loadWidget();
            }
        },

        loadWidget: function() {
            fetch(this.apiUrl + '/render?' + new URLSearchParams(this.config))
                .then(response => response.text())
                .then(html => {
                    this.target.innerHTML = html;
                    this.loadData();
                })
                .catch(error => console.error('Widget loading failed:', error));
        },

        loadData: function() {
            fetch(this.apiUrl + '/data')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('widget-data').innerHTML = this.formatData(data);
                })
                .catch(error => console.error('Data loading failed:', error));
        },

        handleClick: function() {
            fetch(this.apiUrl + '/action', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    action: 'widget_click',
                    timestamp: new Date().toISOString()
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Action successful:', data);
            })
            .catch(error => {
                console.error('Action failed:', error);
            });
        },

        formatData: function(data) {
            return `<div class="widget-data">
                <!-- Format your data here -->
            </div>`;
        }
    };
})(window);