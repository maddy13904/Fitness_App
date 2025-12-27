package com.saveetha.fitnesschallenge;

import android.os.Bundle;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;

public class user_signupActivity extends AppCompatActivity {

    EditText fullName, email, password, confirmPassword;
    CheckBox termsCheckbox;
    Button signUp;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_user_signup);

        fullName = findViewById(R.id.edit_fullname);
        email = findViewById(R.id.edit_email);
        password = findViewById(R.id.edit_password);
        confirmPassword = findViewById(R.id.edit_confirm_password);
        termsCheckbox = findViewById(R.id.checkbox_terms);
        signUp = findViewById(R.id.btn_signup);

        signUp.setOnClickListener(v -> {
            if (!termsCheckbox.isChecked()) {
                Toast.makeText(this, "Please agree to the terms.", Toast.LENGTH_SHORT).show();
                return;
            }

            String name = fullName.getText().toString();
            String mail = email.getText().toString();
            String pass = password.getText().toString();
            String confirmPass = confirmPassword.getText().toString();

            if (name.isEmpty() || mail.isEmpty() || pass.isEmpty()) {
                Toast.makeText(this, "Please fill in all fields.", Toast.LENGTH_SHORT).show();
                return;
            }

            if (!pass.equals(confirmPass)) {
                Toast.makeText(this, "Passwords do not match.", Toast.LENGTH_SHORT).show();
                return;
            }

            // TODO: API Call to your PHP backend to register the user
            Toast.makeText(this, "Registered Successfully!", Toast.LENGTH_SHORT).show();
        });
    }
}
