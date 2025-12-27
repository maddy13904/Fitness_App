package com.saveetha.fitnesschallenge;
import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import androidx.appcompat.app.AppCompatActivity;

public class MainActivity extends AppCompatActivity {

    Button btnGetStarted, btnLogin;


    //github

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        btnGetStarted = findViewById(R.id.btn_get_started);
        btnLogin = findViewById(R.id.btn_login);

        btnGetStarted.setOnClickListener(v -> {
            // Navigate to Register or Onboarding Activity
            // startActivity(new Intent(this, RegisterActivity.class));
        });

        btnLogin.setOnClickListener(v -> {
            // Navigate to Login Activity
            // startActivity(new Intent(this, LoginActivity.class));
        });
    }
}
