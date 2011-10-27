package droid.android2;

import android.app.Activity;
import android.content.Intent;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import com.facebook.android.*;
import com.facebook.android.Facebook.*;

public class AndroidProjectActivity extends Activity {
	

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);

        
        final Button button = (Button) findViewById(R.id.button1);
        button.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                LoginManager m=new LoginManager();
                m.initiateLogin("Facebook", new Callback(){

					public void callBack(String message) {
						 final EditText text = (EditText) findViewById(R.id.editText1);
					        
					        text.setText(message);
					}
                });
            }
        });
    }
}